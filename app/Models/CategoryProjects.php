<?php

namespace App\Models;

use App\Enums\LocationTypeEnum;
use App\Enums\ProjectTypesEnum;
use App\Models\CategoryProjectsTranslation;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class CategoryProjects extends Model
{
    use HasFactory, SoftDeletes, HasTranslations
        // ,Translatable
    ;
    protected $fillable = [
        'parent_id',
        'level',
        'sort',
        'feature',
        'status',
        'statistics',
        'main_home',
        'fast_donation',
        'image',
        'project_types',
        'background_image',
        'background_color',
        'created_by',
        'updated_by',
        'donations_count',
        'visits_count',
        'last_donation_at',
        'statistic_status',
        'cashier_system',
        
    ];
    public $translatable = ['CategoryProjectsTranslation'];

    protected $translationForeignKey = 'category_id';

    public $translatedAttributes = [

        'category_id',
        'locale',
        'title',
        'slug',
        'description',
        'meta_title',
        'meta_description',
        'meta_key',
    ];




    public function getTranslationForeignKey()
    {
        return $this->translationForeignKey;
    }

    public function getTranslationModel()
    {
        return CategoryProjectsTranslation::class;
    }


    // relations ---------------------------------------------------
    public function parent()
    {
        return $this->belongsTo(CategoryProjects::class, 'parent_id', 'id');
    }
    public function children()
    {
        return $this->hasMany(CategoryProjects::class, 'parent_id', 'id');
    }
    public function ads()
    {
        return $this->hasMany(Ads::class, 'model_id', 'id')->where('model', 'App\Models\Categories');
    }
    public function trans()
    {
        return $this->hasMany(CategoryProjectsTranslation::class, 'category_id', 'id');
    }

    public function transNow()
    {
        return $this->hasOne(CategoryProjectsTranslation::class, 'category_id')->where('locale', app()->getLocale());
    }

    public function orders()
    {
        return $this->hasMany(OrderDetails::class, 'item_id', 'id');
    }

    public function sections()
    {
        return $this->belongsToMany(CharitySection::class);
    }

    public function projects()
    {
        return $this->belongsToMany(CharityProject::class, 'charity_category_projects', 'category_id', 'project_id');
    }

    public function cashiers()
    {
        return $this->belongsToMany(Cashier::class, 'cashier_category_project', 'category_project_id', 'cashier_id')
            ->withTimestamps();
    }

    //  scopes --------------------------------------------------------------------------
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    public function scopeFeature($query)
    {
        return $query->where('feature', 1);
    }
    public function scopeCashier($query)
    {
        return $query->where('cashier_system', 1);
    }
    public function scopeProjectType($query, $arg)
    {
        return $query->where('project_types', $arg);
    }
    public function scopeNormal($query)
    {
        return $query->where('project_types', ProjectTypesEnum::NORMAL);
    }
    public function scopeSingle($query)
    {
        return $query->where('project_types', ProjectTypesEnum::SINGLE);
    }
    public function scopeDescesd($query)
    {
        return $query->where('project_types', ProjectTypesEnum::DECESED);
    }
    public function scopeBadal($query)
    {
        return $query->where('project_types', ProjectTypesEnum::BADAL);
    }

    public function scopeFastDonation($query)
    {
        return $query->where('fast_donation', 1);
    }
    public function scopeApp($query)
    {
        return $query->whereHas('projects', function ($q) {
            $q->whereIn('location_type', [LocationTypeEnum::APP, LocationTypeEnum::BOTH])->where('status', 1);
        });
    }
}