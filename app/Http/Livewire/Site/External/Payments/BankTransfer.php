<?php

namespace App\Http\Livewire\Site\External\Payments;

use Livewire\Component;
use App\Traits\FileHandler;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Site\CheckoutController;
use App\Models\PaymentBank;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\URL;

class BankTransfer extends Component
{
    use WithFileUploads, FileHandler;

    protected $listeners = ['updateAuth'];

    public $payment_method_id = 3, $payment_method_key = 'Bank Transfer';
    public $bank_accounts;
    public $payment, $bankHoldName;
    public $bank_id = "", $image;
    public $account_type = "", $iban = "";
    public $project, $amount, $donationtype, $refer;


    protected function rules(){
        return [
            'bank_id' => 'required',
            'image'   => 'required|' . ImageValidate(null, true),
        ];
    }

    public function updateAuth()
    {
        if(@auth('account')->user()?->types->where('type', 'donor')->first() != null){
            $this->render();
        }
    }

    public function updated($field)
    {
        $this->validateOnly($field);
    }

    public function defineData()
    {
        $data = $this->getSanitized();
        $data['amount'] = $this->amount;
        $data['quantity'] = 1;
        $data['refer_id'] = $this->refer->id;
        $data['item_id'] =  $this->project->id;
        $data['item_name'] = $this->project->transNow?->first()->title;
        $data['item_sub_type'] = $this->donationtype;
         
        return $data;
    }

    public function getSanitized()
    {
        $data = $this->validate();
        if ($data['image'] != null) {
            $data['banktransferproof'] = $this->upload_file($data['image'], ('orders'));
        }
        $data['payment_method_id'] = $this->payment_method_id;
        $data['payment_method_key'] = @PaymentBank::find($this->bank_id)->payment_key ?? $this->payment_method_key;
        return $data;
    }

    public function checkout(){

        $data = $this->defineData();

        // Make Order ---
        $order = new CheckoutController();
        $process = $order->externalDonationProcess( $data);

        if( $process['status'] == false){
            session()->flash('warning', $process['message']);
        }
        else{
            session()->flash('success', trans('Your request has been successfully received and is being reviewed'));
            return redirect()->route('site.checkout.success',  $process['order']['identifier']);
            // return redirect()->route('site.external.pages.success',  $process['order']['identifier']);
        }        
    }


    public function updatedbankID($val)
    {
        $selectAccount =  $this->bank_accounts->find($val);
        $this->account_type = $selectAccount['account_type'];
        $this->iban = $selectAccount['iban'];
    }


    public function mount($project, $amount, $donationtype, $refer)
    {
        $this->refer = $refer;
        $this->project = $project;
        $this->amount = $amount;
        $this->donationtype = $donationtype;

        $this->payment = PaymentMethod::find($this->payment_method_id);
        $this->bankHoldName = $this->payment->name_holder;
        $this->bank_accounts = PaymentBank::get();
    }


    public function render()
    {
        return view('livewire.site.external.payments.bank-transfer');
    }
}
