<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CharityProjectTranslation extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    protected $table = 'charity_project_translations';
    protected $fillable = [
        'project_id',
        'title',
        'description',
        'slug',
        'meta_title',
        'meta_description',
        'meta_key',
        'unit_price',
        'locale',
    ];

    public function project()
    {
        return $this->belongsTo(CharityProject::class, 'project_id', 'id');
    }
}
