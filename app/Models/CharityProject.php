<?php

namespace App\Models;

use App\Enums\LocationTypeEnum;
use App\Enums\ProjectTypesEnum;
use App\Models\Review;
use App\Models\CharityTag;
use App\Models\PaymentMethod;
use App\Models\CharityProjectTag;
use App\Models\CategoryProjectsTranslation;
use App\Models\CharitySingleProject;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CharityProject extends Model
{

    use HasFactory, SoftDeletes, Translatable;

    protected $fillable = [
        'category_id',
        'project_types',
        'location_type',
        'number',
        'beneficiary',
        'status',
        'statistics',
        'most_sell',
        'featuer',
        'finished',
        'recurring',
        'sort',
        'fast_donation',
        'cashier_system',
        'donation_type',
        'target_price',
        'target_unit',
        'fake_target',
        'collected_target',
        'start_date',
        'end_date',
        'deceased_id',
        'images',
        'cover_image',
        'background_image',
        'background_color',
        'created_by',
        'updated_by',
        'last_donation_at',
        'statistic_status',
        'visits_count',
        'donations_count',
    ];

    protected $translationForeignKey = 'project_id';
    public $translatedAttributes = [
        'project_id',
        'title',
        'description',
        'slug',
        'meta_title',
        'meta_description',
        'meta_key',
        'locale',
    ];

    public function getTranslationForeignKey(){
        return $this->translationForeignKey;
    }

    public function getTranslationModel(){
        return CategoryProjectsTranslation::class;
    }


    // relations ------------------------------------------------------------------------------
    public function trans()
    {
        return $this->hasMany(CharityProjectTranslation::class, 'project_id');
    }
    public function transNow()
    {
        return $this->hasOne(CharityProjectTranslation::class, 'project_id')->where('locale' , app()->getLocale());
    }

    public function tags()
    {
        return $this->belongsToMany(CharityTag::class, 'charity_project_tags', 'project_id', 'tag_id')->with('trans');
    }

    public function payment()
    {
        return $this->belongsToMany(PaymentMethod::class, 'charity_payment_projects', 'project_id', 'payment_id')->with('trans');
    }

    public function category()
    {
        return $this->belongsTo(CategoryProjects::class);
    }

    public function categories()
    {
        return $this->belongsToMany(CategoryProjects::class, 'charity_category_projects', 'project_id', 'category_id');
    }

    public function decease(){
        return $this->belongsTo(Decease::class, 'id','project_id');
    }

    public function singleField()
    {
        return $this->belongsTo(CharitySingleProject::class, 'id', 'project_id');
    }

    public function badalField()
    {
        return $this->belongsTo(CharityBadalProject::class, 'id', 'project_id');
    }

    public function deceasesField()
    {
        return $this->belongsTo(CharityDeceasedProject::class, 'id', 'project_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class, 'item_id');
    }

    public function cashiers()
    {
        return $this->belongsToMany(Cashier::class, 'cashier_charity_project', 'charity_project_id', 'cashier_id');
    }
    // Scopes -----------------------------------------------------------------------------------
    public function scopeLocationType($query, $arg)
    {
        return $query->where('location_type', $arg);
    }
    public function scopeWeb($query)
    {
        return $query->where('location_type', [LocationTypeEnum::WEB, LocationTypeEnum::BOTH]);
    }
    public function scopeApp($query)
    {
        return $query->whereIn('location_type', [LocationTypeEnum::APP, LocationTypeEnum::BOTH]);
    }
    public function scopeBoth($query)
    {
        return $query->where('location_type', LocationTypeEnum::BOTH);
    }

    public function scopeProjectType($query, $arg)
    {
        return $query->whereIn('project_types', );
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
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    public function scopeStatus($query)
    {
        return $query->where('status', 1);
    }
    public function scopeFeatuer($query)
    {
        return $query->where('featuer', 1);
    }
    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
    public function scopeFastDonation($query)
    {
        return $query->where('fast_donation', 1);
    }

    public function Cashier()
    {

    return $this->belongsToMany(Cashier::class,'cashier_charity_project','charity_project_id','cashier_id')->withTimestamps();
    
    }
}
