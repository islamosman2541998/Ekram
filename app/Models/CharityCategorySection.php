<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharityCategorySection extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'section_id',
    ];


    public function category()
    {
        return $this->belongsTo(CategoryProjects::class, 'category_id');
    }


    public function section()
    {
        return $this->belongsTo(CharitySection::class, 'section_id');
    }
}
