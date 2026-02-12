<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharityCategoryProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'project_id',
    ];


    public function category()
    {
        return $this->belongsTo(CategoryProjects::class, 'category_id');
    }


    public function project()
    {
        return $this->belongsTo(CharityProject::class, 'project_id');
    }


}
