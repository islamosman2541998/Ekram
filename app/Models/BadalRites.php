<?php

namespace App\Models;

use App\Models\Ritestranslation;
use App\Models\Ritestranslations;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BadalRites extends Model
{
    protected $table = 'badal_rites';

    use HasFactory, SoftDeletes, Translatable;

    protected $fillable = [
        'project_id',
        'image',
        'taken_time',
        'proof',
        'sort',
        'status',
        'created_by',
        'updated_by',
    ];
    protected $translationForeignKey = 'rites_id';
    public $translatedAttributes = [
        'rites_id',
        'title',
        'locale',
    ];


    // relations ------------------------------------------------------------------------------
    public function trans()
    {
        return $this->hasMany(Ritestranslation::class, 'rites_id');
    }

    public function project()
    {
        return $this->belongsTo(CharityProject::class, 'project_id')->with('trans');
    }


    public function transNow()
    {
        return $this->hasOne(Ritestranslation::class, 'rites_id')->where('locale' , app()->getLocale());
    }

    // Scopes ----------------------------
    public function scopeBadal($query)
    {
        return $query->where('badal', 1);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);

    }
}
