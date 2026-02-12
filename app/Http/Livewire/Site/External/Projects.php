<?php

namespace App\Http\Livewire\Site\External;

use App\Charity\Settings\SettingSingleton;
use Livewire\Component;

class Projects extends Component
{
    public $project, $donation, $amount, $giftStatus = 0, $cards = [], $selectCardTitle;
    public $donationAmt = 0, $donationQty = 1, $donationtype;
    public $refer;

    public $progressBar = ['collected' => 0, 'reminder' => 0, 'percent' => 0];
    public $unitValueRadio, $unitValueInput;
    public $shareValue, $fixedValue, $openValue;
    public $msg = [];
    public $select_card = 0, $select_category = 0, $select_ocassion = 0;
    public $colors, $colorsAmount = ['bg-secound', 'bg-main', 'bg-dark'];
    public $info_gift, $donation_status = 0, $dynamicAmt = 0;
    public $giver_name = [], $giver_mobile = [], $giver_email = [];
    public $mustLogin = false;


    protected $listeners = [
        'updateAuth',
        'updateDonationAmount',
    ];

    public function updatedUnitValueRadio($data)
    {
        $data = json_decode($data);
        $this->donationAmt    = $data->value;
        $this->donationtype   = $data->name;
        $this->donationQty    = 1;
        $this->unitValueInput = "";
        $this->clear();
    }

    public function updatedUnitValueInput($value)
    {
        $this->donationAmt    = $value;
        $this->donationtype   = $this->project['title'];
        $this->unitValueRadio = "";
        $this->clear();
    }

    public function updatedShareValue($data)
    {
        $data = json_decode($data);
        $this->donationAmt  = $data->value;
        $this->donationtype = $data->name;
        $this->clear();
    }

    public function updatedOpenValue($value)
    {
        $this->donationAmt  = $value;
        $this->donationtype = $this->project['title'];
        $this->clear();
    }

    public function updatedDonationQty()
    {
        if ($this->donation['type'] === 'fixed') {
            $this->donationtype = $this->project['title'];
        }
        $this->clear();
    }

    public function setShareValue($value)
    {
        $this->shareValue = $value;
    }

    public function clear()
    {
        $this->msg = [];
    }

    public function updateAuth()
    {
        $mustLogin = SettingSingleton::getInstance()->getLoginStatus('show_login_project');
        $userType  = auth('account')->user()?->types->where('type', 'donor')->first()?->id;
        $this->mustLogin = $mustLogin && $userType === null;
    }


    public function mount($project, $refer)
    {
        $settingsSingleton = SettingSingleton::getInstance();
        $this->colors = $settingsSingleton->getColor('donation_color') ?? ['#3B82F6', '#10B981', '#8B5CF6'];
        
        if (!is_array($this->colors)) {
            $this->colors = ['#3B82F6', '#10B981', '#8B5CF6'];
        }

        $this->refer   = $refer;
        $this->project   = $project;
        $this->donation  = json_decode($this->project['donation_type'], true);

        if ($this->donation['type'] === "fixed") {
            $this->donationAmt = $this->donation['data'];
        }
        if ($this->donation['type'] === "open") {
            $this->openValue   = $this->donationAmt = $this->amount;
        }
        if ($this->donation['type'] === "share") {
            foreach ($this->donation['data'] as $donshare) {
                if ($donshare['value'] == $this->amount) {
                    $this->donationAmt = $this->amount;
                }
            }
        }
        if ($this->donation['type'] === "unit") {
            $this->unitValueInput = $this->donationAmt = $this->amount;
            foreach ($this->donation['data'] as $donshare) {
                if ($donshare['value'] == $this->amount) {
                    $this->donationAmt     = $this->amount;
                    $this->unitValueInput = 0;
                }
            }
        }

        //calculate the progress bar:
        $activeOrderDetails = 0;
        if (@$project['orderDetails'] != null) {
            $activeOrderDetails = @$project['orderDetails']->filter(function ($detail) {
                return $detail->order?->status === 1;
            })->sum('total') ;
        }

        $this->progressBar['target_price'] = $project['target_price'] == 0 ? 1 : $project['target_price'];
        $this->progressBar['collected'] = ($project['fake_target'] ?? 0) + ($activeOrderDetails?? 0);
        $this->progressBar['avarge'] =  ceil($this->progressBar['collected'] / $this->progressBar['target_price'] * 100) ?? 0;
        if ($this->progressBar['avarge'] > 100) $this->progressBar['avarge'] = 100;

        $this->updateAuth();

    }

    public function render()
    {
       
        return view('livewire.site.external.projects');
    }
}
