<?php

namespace App\View\Components\Site\Home;

use App\Models\News as NewsModel;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class News extends Component
{
    public $news;

    public function __construct()
    {
        $this->news = NewsModel::with('trans')
            ->active()
            ->orderBy('sort', 'ASC')
            ->limit(6)
            ->get();
    }

    public function render(): View|Closure|string
    {
        return view('components.site.home.news');
    }
}