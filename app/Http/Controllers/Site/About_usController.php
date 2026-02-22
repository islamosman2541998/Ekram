<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;


class About_usController extends Controller
{
    public function index()
    {
        return view('site.pages.about');
    }

  
}