<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CharityDeceasedProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'deceased_id',
        'is_approved',
    ];

    
    public function project()
    {
        return $this->belongsTo(CharityProject::class, 'id', 'project_id');
    }
}
