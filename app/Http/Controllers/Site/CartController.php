<?php

namespace App\Http\Controllers\Site;

use App\Charity\Carts\DatabaseCart;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    /**
     * Display the  resource.
     */
    public function index()
    {
        $cartDatabase = new DatabaseCart();
        return view('site.pages.cart', compact('cartDatabase'));
    }
}
