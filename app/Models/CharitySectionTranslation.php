<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharitySectionTranslation extends Model
{
    use HasFactory;

    protected $table = 'charity_section_translations';
    
    protected $fillable = [
        'section_id',
        'locale',
        'title',
        'slug',
        'description',
    ];
}
