<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;


class NewsController extends Controller
{
    public function index()
    {
        $news = \App\Models\News::with('trans')
            ->active()
            ->orderBy('sort', 'ASC')
            ->get();

        return view('site.news.index', compact('news'));
    }

    public function show($slug)
    {
        $news = \App\Models\News::with('trans')
            ->active()
            ->whereHas('trans', function ($q) use ($slug) {
                $q->where('slug', $slug)
                    ->where('locale', app()->getLocale());
            })
            ->firstOrFail();

        return view('site.news.show', compact('news'));
    }
}
