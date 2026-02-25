<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\About;

class About_usController extends Controller
{
    public function index()
    {
        $about = About::with('translations')->first();
        return view('site.pages.about', compact('about'));
    }
}