<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Accounts;
use App\Models\Cart;
use App\Exports\VisitorsExport;
use Maatwebsite\Excel\Facades\Excel;

class VisitorsController extends Controller
{
    public function index(Request $request)
    {
        $query = Accounts::whereHas('donor.carts', function ($q) {
            $q->whereNotNull('item_id');
        })->whereDoesntHave('donor.orders');

        if ($request->filled('mobile')) {
            $query->where('mobile', 'like', '%' . $request->mobile . '%');
        }
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }


        if ($request->filled('status') || $request->status === '0') {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereHas(
                'donor.carts',
                fn($q) =>
                $q->whereBetween('created_at', [$request->start_date, $request->end_date])
            );
        }

        $query->with(['donor' => function ($q) {
            $q->select('id', 'account_id', 'full_name');
            $q->withCount(['carts' => function ($q2) {
                $q2->whereNotNull('item_id');
            }]);
        }])->get();
        $visitors = $query->orderBy('id', 'desc')
            ->paginate($this->pagination_count)
            ->appends($request->all());

        return view('admin.dashboard.visitors.visitors', compact('visitors'));
    }

    public function export(Request $request)
    {
        $filters = $request->only(['mobile', 'status', 'start_date', 'end_date']);
        $fileName = 'visitors_' . now()->format('Ymd_His') . '.xlsx';


        return Excel::download(new VisitorsExport($filters), $fileName);
    }
}
