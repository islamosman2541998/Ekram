<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Donor;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MoyasarPaymentController extends Controller
{
    /**
     * عرض صفحة الدفع - فورم ميسّر
     */
    public function showPaymentForm(Request $request, $identifier)
    {
        $order = Order::where('identifier', $identifier)->firstOrFail();

        // لو الأوردر مدفوع بالفعل
        if ($order->status == 1) {
            session()->flash('success', __('Thank you for your donation through Nama'));
            return redirect()->route('site.checkout.success', $order->identifier);
        }

        // المبلغ بالهللات (ميسّر يستقبل أصغر وحدة عملة)
        $amountInHalalas = intval($order->total * 100);

        return view('site.pages.checkout.moyasar-payment', [
            'order'          => $order,
            'amount'         => $amountInHalalas,
            'publishableKey' => config('moyasar.publishable_key'),
            'callbackUrl'    => route('site.moyasar.callback'),
            'description'    => 'تبرع - طلب رقم ' . $order->identifier,
        ]);
    }

    /**
     * حفظ معرف الدفع قبل 3DS redirect (اختياري لكن مهم)
     */
    public function savePaymentId(Request $request)
    {
        $request->validate([
            'payment_id' => 'required|string',
            'order_id'   => 'required',
        ]);

        $order = Order::find($request->order_id);
        if ($order) {
            $order->payment_proof = json_encode([
                'moyasar_payment_id' => $request->payment_id,
                'saved_at'           => now()->toDateTimeString(),
            ]);
            $order->save();
        }

        return response()->json(['status' => 'ok'], 201);
    }

    /**
     * Callback بعد الدفع - ميسّر بيرجع المستخدم هنا
     * URL: ?id=xxx&status=paid&message=Succeeded
     */
    public function callback(Request $request)
    {
        $paymentId = $request->query('id');
        $status    = $request->query('status');
        $message   = $request->query('message');

        if (!$paymentId) {
            session()->flash('warning', 'حدث خطأ في عملية الدفع');
            return redirect()->route('site.checkout.show');
        }

        // تحقق من الدفع عن طريق API (مهم جداً!)
        $payment = $this->verifyPayment($paymentId);

        if (!$payment) {
            session()->flash('warning', 'تعذر التحقق من عملية الدفع');
            return redirect()->route('site.checkout.show');
        }

        // استخرج الـ order من metadata
        $orderId = $payment['metadata']['order_id'] ?? null;

        // لو مفيش order_id في metadata، جرب تدور بالـ payment_proof
        if (!$orderId) {
            $order = Order::where('payment_proof', 'LIKE', '%' . $paymentId . '%')->first();
        } else {
            $order = Order::find($orderId);
        }

        if (!$order) {
            Log::error('Moyasar callback: Order not found', [
                'payment_id' => $paymentId,
                'metadata'   => $payment['metadata'] ?? [],
            ]);
            session()->flash('warning', 'لم يتم العثور على الطلب');
            return redirect()->route('site.checkout.show');
        }

        // لو مدفوع بالفعل
        if ($order->status == 1) {
            session()->flash('success', __('Thank you for your donation through Nama'));
            return redirect()->route('site.checkout.success', $order->identifier);
        }

        // تحقق من المبلغ والعملة
        $expectedAmount = intval($order->total * 100);
        if ($payment['amount'] != $expectedAmount || $payment['currency'] != 'SAR') {
            Log::error('Moyasar payment amount mismatch', [
                'payment_id'      => $paymentId,
                'expected_amount' => $expectedAmount,
                'received_amount' => $payment['amount'],
                'currency'        => $payment['currency'],
            ]);
            session()->flash('warning', 'خطأ في التحقق من المبلغ');
            return redirect()->route('site.checkout.show');
        }

        // حدث حالة الأوردر
        $order->payment_proof = json_encode($payment);

        if ($payment['status'] === 'paid') {
            $order->status = 1;
            $order->save();

            // امسح السلة
            $this->clearCart($order);

            session()->flash('success', __('Thank you for your donation through Nama'));
            return redirect()->route('site.checkout.success', $order->identifier);
        } else {
            $order->status = 0;
            $order->save();

            $errorMsg = $message ?? 'فشلت عملية الدفع';
            session()->flash('warning', $errorMsg);
            return redirect()->route('site.checkout.show', ['msg' => $errorMsg]);
        }
    }

    /**
     * Webhook - ميسّر بيبعت إشعار على السيرفر مباشرة
     */
    public function webhook(Request $request)
    {
        $payload = $request->all();

        Log::info('Moyasar Webhook received', $payload);

        $paymentId = $payload['id'] ?? null;

        if (!$paymentId) {
            return response()->json(['error' => 'Missing payment ID'], 400);
        }

        // تحقق من الدفع عن طريق API
        $payment = $this->verifyPayment($paymentId);
        if (!$payment) {
            return response()->json(['error' => 'Payment verification failed'], 400);
        }

        $orderId = $payment['metadata']['order_id'] ?? null;

        if (!$orderId) {
            $order = Order::where('payment_proof', 'LIKE', '%' . $paymentId . '%')->first();
        } else {
            $order = Order::find($orderId);
        }

        if (!$order) {
            Log::error('Moyasar webhook: Order not found', ['payment_id' => $paymentId]);
            return response()->json(['error' => 'Order not found'], 404);
        }

        // حدث بس لو مش مدفوع
        if ($order->status != 1 && $payment['status'] === 'paid') {
            $order->status        = 1;
            $order->payment_proof = json_encode($payment);
            $order->save();

            $this->clearCart($order);
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     */
   private function verifyPayment(string $paymentId): ?array
{
    try {
        $http = Http::withBasicAuth(config('moyasar.key'), '');
        
        if (app()->environment('local')) {
            $http = $http->withoutVerifying();
        }
        
        $response = $http->get("https://api.moyasar.com/v1/payments/{$paymentId}");

        if ($response->successful()) {
            return $response->json();
        }

        Log::error('Moyasar verify failed', [
            'payment_id' => $paymentId,
            'status'     => $response->status(),
            'response'   => $response->body(),
        ]);
        return null;
    } catch (\Exception $e) {
        Log::error('Moyasar verify exception', ['error' => $e->getMessage()]);
        return null;
    }
}

    /**
     * مسح السلة بعد الدفع الناجح
     */
    private function clearCart(Order $order): void
    {
        try {
            $donor = Donor::find($order->donor_id);
            if ($donor) {
                Cart::where('donor_id', $donor->id)->delete();
            }
            Cookie::queue('cart', '');
            Cookie::queue(Cookie::forget('cart'));
        } catch (\Exception $e) {
            Log::warning('Failed to clear cart', ['error' => $e->getMessage()]);
        }
    }
}