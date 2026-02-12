<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharitySingleProjectTranslation extends Model
{
    use HasFactory;
    protected $table = 'charity_single_translations';
    protected $fillable = [
        'single_id',
        'gift_title',
        'locale',
     ];
}
