<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'item_type',
        'item_name',
        'item_id',
        'item_sub_type',
        'cookeries',
        'quantity',
        'price',
        'cart_id',
        'gift_details',
        'givten_details',
        'gift_card_details',
        'gift_products_details',
        'gift_projects_details',
        'donor_id',
        'vendor_id',
    ];

    public function item()
    {
        return $this->morphTo()->with('trans');
    }

    public function donor()
    {
        return $this->belongsTo(Donor::class, 'donor_id');
    }
}
