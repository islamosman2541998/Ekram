<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class About extends Model
{
    use Translatable, SoftDeletes;

    protected $table = 'abouts';
    protected $guarded = [];
    public $translatedAttributes = ['title', 'description', 'mission_title', 'mission_description', 'vision_title', 'vision_description', 'values_title', 'values_description'];

    public function trans()
{
    return $this->hasMany(AboutTranslation::class, 'about_id');
}
}