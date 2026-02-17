<?php

namespace App\Http\Livewire\Site\FastDonation\Payments;

use App\Enums\SourcesEnum;
use Livewire\Component;
use App\Http\Controllers\Site\CheckoutController;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Cookie;

class ApplePay extends Component
{


    public $payment_method_id = 4 , $payment_method_key = 'ApplePay';

    public $amount = 0;

    public $order;

    public $testMode = "", $url = "", $mechant_identifier = "", $access_code = "", $SHARequestPhrase = "", $SHAResponsePhrase = "";

    public $donationData;

    protected $listeners = ['getFastDonationData'];

    public function getFastDonationData($donationData)
    {
        $this->donationData = $donationData;
    }

    public function updateAuth()
    {
        if(@auth('account')->user()?->types->where('type', 'donor')->first() != null){
            $this->render();
        }
    }


    public function mount($dataDonation)
{
    $this->donationData = $dataDonation;
    $this->payment_method_key = @PaymentMethod::find($this->payment_method_id)->payment_key;
}
public function checkout()
{
    $data['payment_method_id'] = $this->payment_method_id;
    $data['payment_method_key'] = $this->payment_method_key;
    $data['mobile']       = @$this->donationData['mobile'];
    $data['name']         = @$this->donationData['name'];
    $data['total']        = $this->donationData['donationAmt'];
    $data['quantity']     = 1;
    $data['source']       = SourcesEnum::WEB;
    $data['refer_id']     = Cookie::get('referrer');
    $data['item_id']      = $this->donationData['project']['id'];
    $data['item_name']    = $this->donationData['project_name'];
    $data['item_type']    = $this->donationData['donationtype'];

    $order = new CheckoutController();
    $process = $order->fastDonationProcess($data);
    return redirect()->route('site.moyasar.payment', $process['order']->identifier);
}

    public function render()
    {
        return view('livewire.site.fast-donation.payments.apple-pay');
    }
}
