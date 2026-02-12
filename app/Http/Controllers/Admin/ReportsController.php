<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ReportsController extends Controller
{
    public function orderProducts(){
        return view('admin.dashboard.reports.products-order');

    }
}