<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BadalOffer extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'substitute_id',
        'badal_project_id',
        'amount',
        'start_at',
        'status',
    ];


    public function badalProject()
    {
        return $this->belongsTo(CharityBadalProject::class , 'badal_project_id');
    }

    public function project()
    {
        return $this->belongsTo(CharityProject::class , 'badal_project_id');
    }

    public function substitute()
    {
        return $this->belongsTo(Substitutes::class , 'substitute_id');
    }


    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }


}
