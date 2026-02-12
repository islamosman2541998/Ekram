<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftCards extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'image',
        'sort',
        'price',
        'status',
        'created_by',
        'updated_by',
    ];

    public function category()
    {
        return $this->belongsTo(GiftCategories::class,'category_id',  'id');
    }

    public function occasioins()
    {
        return $this->belongsToMany(GiftOccasioins::class, 'gifts_card_occasions', 'card_id', 'occasioin_id');
    }

}
