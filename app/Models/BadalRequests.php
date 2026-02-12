<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BadalRequests extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'badal_id',
        'substitute_id',
        'start_at',
        'is_selected',
        'status',
    ];


    // relations
    public function badal()
    {
        return $this->belongsTo(BadalOrder::class, 'badal_id');
    }
    public function substitute()
    {
        return $this->belongsTo(Substitutes::class , 'substitute_id');
    }
    
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
