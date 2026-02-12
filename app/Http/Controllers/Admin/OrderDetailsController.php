<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrderDetailsExport;

class OrderDetailsController extends Controller
{

    public function index(Request $request)
    {
        $query = $this->filter($request);

        if ($request->type  == "excel") {
            return Excel::download(new OrderDetailsExport($query->get()), 'orders_details.xlsx');
            // return Excel::download(new OrderDetailsExport(collect($query->get())), 'orders_details.xlsx')->withCookie(LocaleCookieRedirect::class);
        }

        $countOrder = $query->count();
        $totalOrder = $query->sum('total');
        $countProductOrder = $query->sum('quantity');

        $orderDetails = $query->orderBy('created_at', 'desc')->paginate($this->pagination_count);
        $refers = \App\Models\Refer::orderBy('name')->get();
        $items = OrderDetails::select('item_name')
            ->distinct()
            ->orderBy('item_name')
            ->pluck('item_name');

        $paymentMethods  = \App\Models\PaymentMethod::orderBy('payment_key')->get();


        return view('admin.dashboard.reports.order_details.index', compact('orderDetails', 'countOrder', 'totalOrder', 'countProductOrder', 'refers', 'paymentMethods', 'items'));
    }


    public function filter($request){
        $query = OrderDetails::Has('order')->with(['order.refer', 'order.donor.account', 'order.paymentMethod', 'order.donor', 'item', 'vendor']);

        if ($request->has('search_id') && $request->search_id != "") {
            $query->whereHas('order', function ($q) use ($request) {
                $q->where('id', 'like', '%' . $request->search_id . '%');
            });
        }
        if ($request->filled('order_details_id')) {
            $id = (int) $request->order_details_id;
            $query->where('id', $id);
        }
        if ($request->filled('search_refer')) {
            $referId = (int) $request->search_refer;
            $query->whereHas('order', function ($q) use ($referId) {
                $q->where('refer_id', $referId);
            });
        }
        if ($request->filled('donor_email')) {
            $email = trim($request->donor_email);
            $query->whereHas('order', function ($q) use ($email) {
                $q->whereHas('donor', function ($q2) use ($email) {
                    $q2->whereHas('account', function ($q3) use ($email) {
                        $q3->where('email', 'like', '%' . $email . '%');
                    });
                });
            });
        }


        if ($request->filled('donor_mobile')) {
            $mobile = trim($request->donor_mobile);
            $query->whereHas('order', function ($q) use ($mobile) {
                $q->whereHas('donor', function ($q2) use ($mobile) {
                    $q2->where('mobile', 'like', '%' . $mobile . '%');
                });
            });
        }
        if ($request->filled('item_name')) {
            $itemName = $request->item_name;

            $query->where('item_name', $itemName);
        }
        if ($request->filled('payment_key')) {
            $payment_key = $request->payment_key;
            $query->whereHas('order.paymentMethod', function ($q) use ($payment_key) {
                $q->where('payment_key', $payment_key);
            });
        }

        if ($request->has('search_product') && $request->search_product != "") {
            $query->whereHas('item', function ($q) use ($request) {
                $q->where('item_name', 'like', '%' . $request->search_product . '%');
            });
        }
        if ($request->filled('order_status')) {
            $orderStatus = (int) $request->order_status;
            $query->whereHas('order', function ($q) use ($orderStatus) {
                $q->where('status', $orderStatus);
            });
        }
        if ($request->has('search_created_from') && $request->search_created_from != "") {
            $query->whereDate('created_at', '>=', $request->search_created_from);
        }

        if ($request->has('search_created_to') && $request->search_created_to != "") {
            $query->whereDate('created_at', '<=', $request->search_created_to);
        }
        return $query;
    }

    public function export(Request $request)
    {
        $query = $this->filter($request);

        return Excel::download(new OrderDetailsExport($query->get()), 'orders_details.xlsx');
        
    }
}
