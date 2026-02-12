<?php

namespace App\Models;

use App\Enums\ShippingStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class OrderDetails extends Model
{
    use HasFactory, SoftDeletes;
    
    
    public $fillable = [
        'order_id',
        'order_details_id',
        'item_type',
        'item_id',
        'item_name',
        'item_sub_type',
        'quantity',
        'price',
        'total',
        'is_gift',
        'giver_id',
        'gift_details',
        'vendor_id',
        'note',
        'status',
        'shipping_status',
        'rate',
        'review',
    ];

    // relations -----------------------------------------
    public function order(){
        return $this->belongsTo(Order::class);
    }


    public function project(){
        return $this->belongsTo(CharityProject::class, 'item_id', 'id');
    }

    public function item()
    {
        return $this->morphTo()->with('trans');
    }

    public function giver(){
        return $this->belongsTo(Giver::class, 'id', 'order_id');
    }

    public function vendor(){
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }


    // scope
    public function scopeShippingPending($query)
    {
        return $query->where('shipping_status', ShippingStatusEnum::PENDING);
    }
}
