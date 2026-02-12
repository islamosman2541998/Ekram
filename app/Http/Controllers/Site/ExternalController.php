<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\CharityProject;
use App\Models\Refer;
use Illuminate\Http\Request;

class ExternalController extends Controller
{
    public function show(Request $request, $product = null, $referer = null)
    {

        $refer = Refer::where('code', $referer)->first() ?? Refer::find(1);

        if (is_numeric($product)) {
            $project = CharityProject::with(['trans', 'categories', 'categories.trans'])->findOrFail($product);
        } else {
            $project = CharityProject::with(['trans', 'categories', 'categories.trans'])
                ->whereHas('trans', function ($q) use ($product) {
                    $q->where('slug', $product);
                })
                ->first();
    
            if ($project == null) {
                abort(404);
            }
        }
        return view('site.external.pages.project', compact('project', 'refer'));
    }
}
