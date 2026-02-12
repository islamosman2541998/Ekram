<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CharityBadalProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'badal_type',
        'min_price',
    ];

    public function project()
    {
        return $this->belongsTo(CharityProject::class, 'project_id');
    }

 }
