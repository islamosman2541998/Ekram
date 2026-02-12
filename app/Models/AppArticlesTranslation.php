<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppArticlesTranslation extends Model
{
    use HasFactory;

    use HasFactory;
    protected $table = 'app_articles_translations';

    protected $fillable = [
        'article_id',
        'locale',
        'title',
        'slug',
        'description',
    ];
}
