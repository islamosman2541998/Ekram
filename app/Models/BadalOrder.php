<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BadalOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'substitute_id',
        'project_id',
        'is_offer',
        'offer_id',
        'behafeof',
        'relation',
        'language',
        'gender',
        'start_at',
        'complete_at',
        'status',
    ];

    // relations
    public function order()
    {
        return $this->belongsTo(Order::class , 'order_id');
    }
    public function substitute()
    {
        return $this->belongsTo(Substitutes::class , 'substitute_id');
    }
    public function project()
    {
        return $this->belongsTo(CharityProject::class , 'project_id');
    }
    public function offer()
    {
        return $this->belongsTo(BadalOffer::class , 'offer_id');
    }
    public function review()
    {
        return $this->belongsTo(BadalReview::class , 'badal_id');
    }
    public function requests()
    {
        return $this->hasMany(BadalRequests::class, 'badal_id', 'id');
    }
}
