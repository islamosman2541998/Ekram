<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
class CharitySection extends Model
{
    use HasFactory, Translatable, SoftDeletes;

    protected $fillable = [
        'sort',
        'feature',
        'status',
        'image',
        'background_image',
        'created_by',
        'updated_by',

    ];

    protected $translationForeignKey = 'section_id';

    public $translatedAttributes = [
        'section_id',
        'title',
        'slug',
        'description',
        'locale',
    ];

    // relations ------------------------------------------------------------------------------
    public function trans()
    {
        return $this->hasMany(CharitySectionTranslation::class, 'section_id');
    }

    public function categories()
    {
        return $this->belongsToMany(CategoryProjects::class, 'charity_category_sections', 'section_id', 'category_id');
    }
    
}
