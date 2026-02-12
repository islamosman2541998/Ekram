<?php

namespace App\Models;

use App\Models\PaymentMethod;
use App\Models\CharityProject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CharityPaymentProject extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'project_id',
        'payment_id',
    ];
    // relations 
    public function project(){
        return $this->belongsTo(CharityProject::class, 'project_id');
    }

    public function paymentMethod(){
        return $this->belongsTo(PaymentMethod::class, 'payment_id');
    }
}
