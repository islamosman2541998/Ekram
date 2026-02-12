<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CharitySingleProject extends Model
{
    use HasFactory, Translatable, SoftDeletes;

    protected $fillable = [
        'project_id',
        'hidden',
        'gift',
        'mobile_confirmation',
    ];

    protected $translationForeignKey = 'single_id';
    public $translatedAttributes = [
        'gift_title',
    ];


    public function trans()
    {
        return $this->hasMany(CharitySingleProjectTranslation::class, 'single_id');
    }
    
    public function project()
    {
        return $this->belongsTo(CharityProject::class, 'id', 'project_id');
    }

}
