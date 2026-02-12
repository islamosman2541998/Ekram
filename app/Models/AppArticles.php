<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppArticles extends Model
{
    use HasFactory, SoftDeletes, Translatable;

    protected $fillable = [
        'section_id',
        'hits',
        'sort',
        'image',
        'feature',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $translationForeignKey = 'article_id';
    public $translatedAttributes = [
        'article_id',
        'locale',
        'title',
        'slug',
        'description',
    ];


    public function trans(){
        return $this->hasOne(AppArticlesTranslation::class, 'article_id', 'id')->where('locale' , app()->getLocale());
    }


      public function section(){
        return $this->belongsTo(AppSection::class,'section_id')->with('trans');
    }
    

    // Scopes ----------------------------
    public function scopeActive($query){
        return $query->where('status', 1);
    }
    public function scopeFeature($query){
        return $query->where('feature', 1);
    }

}
