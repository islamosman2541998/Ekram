<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Crypt;

class CreditCard extends Model
{
    use HasFactory, SoftDeletes;

    // public $fillable = [
    //     'donor_id',
    //     'name',
    //     'number',
    //     'expired_month',
    //     'expired_year',
    //     'merchant_reference',
    //     'token_name',
    //     'default',
    //     'status',
    // ];
    public $guarded = [];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    protected function numberddd(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Crypt::decryptString($value),
            set: fn (string $value) => Crypt::encryptString($value),
        );
    }


    protected function cardnumber(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => Crypt::decryptString($attributes['number']),
        );
    }
}
