<?php

namespace App\Models;

use App\Models\CharityTag;
use App\Models\TagProjects;
use App\Models\CharityProject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CharityProjectTag extends Model
{
    protected $table = 'charity_project_tags';
    protected $fillable = [
        'project_id',
        'tag_id',
    ];

    // relations 
    public function project(){
        return $this->belongsTo(CharityProject::class, 'project_id');
    }

    public function tagProject(){
        return $this->belongsTo(CharityTag::class, 'tag_id');
    }
}
