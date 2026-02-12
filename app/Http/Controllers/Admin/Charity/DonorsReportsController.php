<?php

namespace App\Http\Controllers\Admin\Charity;

use App\Models\Donor;
use App\Models\Accounts;
use App\Models\LoginTypes;
use App\Models\AddressDonor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Charity\donorsRequest;
use App\Models\Refer;
use App\Exports\DonorsExport;
use App\Exports\ExportUsers;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class DonorsReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Donor::query()->orderBy('id', 'DESC')->withCount('orders')->withSum('orders', 'total');

        if ($request->status  != '') {
            $query->where('status', $request->status);
        }
        if ($request->name  != '') {
            $query->where('full_name', 'like', '%' . $request->name . '%');
        }
        if ($request->email  != '') {
            $query->whereHas('account', function ($q) {
                $q->where('email', 'like', '%' . request()->email . '%');
            });
        }
        if ($request->mobile  != '') {
            $query->whereHas('account', function ($q) {
                $q->where('mobile', 'like', '%' . request()->mobile . '%');
            });
        }

        // Add date range filtering
        if ($request->date_from != '') {
            $query->whereDate('created_at', '>=', Carbon::parse($request->date_from)->startOfDay());
        }

        if ($request->date_to != '') {
            $query->whereDate('created_at', '<=', Carbon::parse($request->date_to)->endOfDay());
        }

        if ($request->orders_from != '') {
            $query->having('orders_count', '>=', $request->orders_from);
        }

        if ($request->orders_to != '') {
            $query->having('orders_count', '<=', $request->orders_to);
        }
        if ($request->price_from != '') {
            $query->having('orders_sum_total', '>=', $request->price_from);
        }

        if ($request->price_to != '') {
            $query->having('orders_sum_total', '<=', $request->price_to);
        }
        if ($request->refer_name != '') {
            $query->whereHas('refer', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->refer_name . '%');
            });
        }

        if (request()->submit == 'export') {
            return Excel::download(new DonorsExport($query->get()), 'donors.xlsx');
        }

        $donor = $query->paginate($this->pagination_count);
        return view('admin.dashboard.chairty.donor-reports.index', compact('donor'));
    }
}
