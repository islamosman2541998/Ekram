<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;


    protected $fillable = ['key', 'status'];

    /**
     * The real setting groups (key => what it controls), shown in the admin settings list.
     */
    public const GROUPS = [
        'general'             => 'اللوجو، رسالة الترحيب، روابط التطبيقات، الفوتر، البانر والإحصائيات، وإظهار أو إخفاء أقسام الصفحة الرئيسية (السلايدر، التبرع السريع، الأقسام...)',
        'meta'                => 'عنوان ووصف الموقع وكلماته المفتاحية لمحركات البحث (SEO)',
        'gift'                => 'الإهداء الخيري: عنوان ووصف صفحة الإهداء، تصنيفات وتصاميم بطاقات الإهداء، ومكان الأسماء على البطاقة',
        'color'               => 'ألوان الموقع وألوان أقسام التبرع والفوتر',
        'login'               => 'هل التبرع يتطلب تسجيل دخول، وإرسال كود التحقق (OTP) في صفحة المشروع والسلة والدفع',
        'product'             => 'إعدادات متجر الإهداءات',
        'custom_campaign'     => 'طلبات إنشاء الحملات/المشاريع المخصصة والبريد الذي يستقبلها',
        'external_connection' => 'الربط الخارجي: إعدادات البريد (SMTP) ومفاتيح الـ API',
        'contact_information' => 'أرقام التواصل، الواتساب، البريد، العنوان والخريطة، مواعيد العمل، وروابط السوشيال ميديا',
        'notifications'       => 'رسائل التنبيه التي تُرسل للمتبرع عند استلام الطلب وتأكيده',
        'volunteering'        => 'صفحة التطوع: العنوان، رقم الواتساب، الإنجازات والمبادرات',
        'badal'               => 'خدمة البدل (الحج/العمرة عن الغير): التفعيل، المشاريع، مدة العروض والتأخير',
        'badalnotfication'    => 'رسائل التنبيه الخاصة بطلبات البدل',
        'pixel'               => 'أكواد التتبع: جوجل، ميتا، سناب شات، تيك توك، تويتر',
    ];

    public function getDescriptionAttribute()
    {
        return self::GROUPS[$this->key] ?? '';
    }

    //  Relations 
    public function values()
    {
        return $this->hasMany(SettingsValues::class, 'setting_id', 'id');
    }


    //  Mutators & Casting 
    /**
     * @return mixed
     */
    public function getTitleAttribute()
    {
        return @$this->values->where('key', 'title')->first()?->value ?? trans('settings.' . $this->key);
    }
    //  End Mutators & Casting 


    // Scopes ----------------------------
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

}
