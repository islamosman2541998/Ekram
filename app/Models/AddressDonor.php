<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressDonor extends Model
{
    use HasFactory;
    public $fillable = [
        'city',
        'country',
        'state',
        'address',
        'nationality',
        'status',
        'created_by',
        'updated_by',
        'doner_id',
    ];
}
