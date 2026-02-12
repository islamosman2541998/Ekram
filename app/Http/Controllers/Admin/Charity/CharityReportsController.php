<?php

namespace App\Http\Controllers\Admin\Charity;

use App\Models\Review;
use App\Models\CharityTag;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\CharityProject;
use App\Models\CategoryProjects;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Charity\CharityProjectRequest;

class  CharityReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dashboard.chairty.charity-report.index');
    }
}
