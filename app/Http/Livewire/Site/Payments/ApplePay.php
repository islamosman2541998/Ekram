<?php

namespace App\Http\Livewire\Site\Payments;

use App\Charity\Carts\DatabaseCart;
use App\Http\Controllers\Site\CheckoutController;
use App\Models\PaymentMethod;
use Livewire\Component;

class ApplePay extends Component
{


    public $payment_method_id = 4 , $payment_method_key = 'ApplePay';

    public $amount = 0;

    public $order;

    public $testMode = "", $url = "", $mechant_identifier = "", $access_code = "", $SHARequestPhrase = "", $SHAResponsePhrase = "";

    protected $listeners = ['updateAuth'];


    public function updateAuth()
    {
        if(@auth('account')->user()?->types->where('type', 'donor')->first() != null){
            $this->render();
        }
    }



 public function checkout(){
    $data['payment_method_id'] = $this->payment_method_id;
    $data['payment_method_key'] = $this->payment_method_key;

    $order = new CheckoutController();
    $process = $order->process($data);
    
    // Moyasar بدل PayFort
    return redirect()->route('site.moyasar.payment', $process['order']->identifier);
}

   public function mount(){
    $this->payment_method_key = @PaymentMethod::find($this->payment_method_id)->payment_key;
}


    public function render()
    {
        return view('livewire.site.payments.apple-pay');
    }

}
