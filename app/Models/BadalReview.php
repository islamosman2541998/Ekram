<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BadalReview extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'badal_id',
        'rate',
        'description',
        'email_reply',
        'sms_reply',
        'status',
    ];


    // relations
    public function badal()
    {
        return $this->belongsTo(BadalOrder::class, 'badal_id');
    }
}
