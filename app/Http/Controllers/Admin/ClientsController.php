<?php

namespace App\Http\Controllers\Admin;

use App\Models\Donor;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ClientsExport;
use Carbon\Carbon;


use App\Http\Controllers\Controller;

class ClientsController extends Controller
{
    public function index(Request $request)
    {
        $query = Donor::with(['orders' => fn($q) => $q->orderBy('created_at', 'desc'), 'account'])
            ->whereHas('orders');

        if ($request->filled('mobile')) {
            $query->where('mobile', 'like', '%' . $request->mobile . '%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereHas(
                'orders',
                fn($q) =>
                $q->whereBetween('created_at', [$request->start_date, $request->end_date])
            );
        }
        if ($request->filled('total_from')) {
            $query->whereHas(
                'orders',
                fn($q) =>
                $q->selectRaw('donor_id, SUM(total) as sum_total')
                    ->groupBy('donor_id')
                    ->having('sum_total', '>=', $request->total_from)
            );
        }
        if ($request->filled('total_to')) {
            $query->whereHas(
                'orders',
                fn($q) =>
                $q->selectRaw('donor_id, SUM(total) as sum_total')
                    ->groupBy('donor_id')
                    ->having('sum_total', '<=', $request->total_to)
            );
        }
        if ($request->input('submit') === 'excel') {
            $timestamp = Carbon::now()->format('Ymd_His');
            return Excel::download(
                new ClientsExport,
                "clients_export_{$timestamp}.xlsx"
            );
        }
        $query->withCount([
            'orders as paid_count'   => fn($q) => $q->whereIn('status', [1]),
            'orders as unpaid_count' => fn($q) => $q->whereNotIn('status', [1]),
        ]);

        $query->withSum([
            'orders as paid_total'   => fn($q) => $q->whereIn('status', [1]),
            'orders as unpaid_total' => fn($q) => $q->whereNotIn('status', [1]),
        ], 'total');

        // Pagination
        $clients = $query->orderBy('id', 'desc')
            ->paginate($this->pagination_count)
            ->appends($request->all());

        $search = $request->filled(['mobile', 'status', 'start_date', 'end_date', 'total_from', 'total_to']);

        return view('admin.dashboard.clients.clients', compact('clients', 'search'));
    }

    public function export(Request $request)
    {
        $filters = $request->only([
            'mobile',
            'status',
            'start_date',
            'end_date',
            'total_from',
            'total_to',
        ]);

        return Excel::download(
            new ClientsExport($filters),
            'clients_' . now()->format('Ymd_His') . '.xlsx'
        );
    }
}
