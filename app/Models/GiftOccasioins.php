<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class GiftOccasioins extends Model
{
    use HasFactory, Translatable, SoftDeletes;

    protected $fillable = [
        'sort',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $translationForeignKey = 'occasioin_id';

    public $translatedAttributes = [
        'occasioin_id',
        'locale',
        'title',
    ];

    public function trans()
    {
        return $this->hasMany(GiftOccasioinsTranslation::class, 'occasioin_id', 'id');
    }

    public function scopeActive($query){
        return $query->where('status', 1);
    }
}


