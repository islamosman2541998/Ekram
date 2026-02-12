<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientsCart extends Model
{
    use HasFactory;
    protected $table = 'clients_carts';


    protected $fillable = [
        'cart_id',
        'donor_id',
        'item_type',
        'item_name',
        'item_id',
        'item_sub_type',
        'quantity',
        'price',
        'total_price',
        'status'
    ];


    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    public function donor()
    {
        return $this->belongsTo(Donor::class, 'donor_id');
    }
}
