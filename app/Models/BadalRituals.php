<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BadalRituals extends Model
{
    use HasFactory;

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'project_id',
        'substitute_id',
        'rite_id',
        'title',
        'description',
        'type',
        'proof',
        'start',
        'start_time',
        'complete',
        'status',
    ];


    // relations
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function projects()
    {
        return $this->belongsTo(CharityProject::class, 'project_id');
    }

    public function substitute()
    {
        return $this->belongsTo(Substitutes::class, 'substitute_id');
    }

    public function rite()
    {
        return $this->belongsTo(BadalRites::class, 'rite_id');
    }
}
