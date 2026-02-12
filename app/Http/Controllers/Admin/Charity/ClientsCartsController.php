<?php

namespace App\Http\Controllers\Admin\Charity;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Donor;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class ClientsCartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)
    {
      

        $carts = Cart::with(['item', 'donor', 'donor.account'])
                ->select('carts.*')
                ->addSelect([
                    'total_price' => DB::table('carts as c')
                        ->selectRaw('SUM(price * quantity)')
                        ->whereColumn('c.id', 'carts.id')
                        ->whereNull('c.deleted_at')
                ])
                ->orderBy('cookeries');

                



        if ($request->has('item_name') && $request->input('item_name') != '') {
            $carts->where('item_name', 'like', '%' . $request->input('item_name') . '%');
        }

        if ($request->has('mobile') && $request->input('mobile') != '') {
            $carts->whereHas('donor', function ($query) use ($request) {
                $query->where('mobile', 'like', '%' . $request->input('mobile') . '%');
            });
        }

        if ($request->has('min_price') && $request->input('min_price') != '' && $request->has('max_price') && $request->input('max_price') != '') {
            $carts->whereBetween('price', [$request->input('min_price'), $request->input('max_price')]);
        } elseif ($request->has('min_price') && $request->input('min_price') != '') {
            $carts->where('price', '>=', $request->input('min_price'));
        } elseif ($request->has('max_price') && $request->input('max_price') != '') {
            $carts->where('price', '<=', $request->input('max_price'));
        }

         if ($request->filled('from_date') && $request->filled('to_date')) {
            $carts->whereBetween('created_at', [$request->from_date.' 00:00:00', $request->to_date.' 23:59:59']);
        } elseif ($request->filled('from_date')) {
            $carts->where('created_at', '>=', $request->from_date.' 00:00:00');
        } elseif ($request->filled('to_date')) {
            $carts->where('created_at', '<=', $request->to_date.' 23:59:59');
        }
        if ($request->has('cookeries') && $request->input('cookeries') != '') {
            $carts->where('cookeries', 'like', '%' . $request->input('cookeries') . '%');
        }
        
        $filtered = (clone $carts)->get();

        $totalSum = $carts->get()->sum('total_price');
        $carts = $carts->paginate($this->pagination_count)->appends($request->all());

        return view('admin.dashboard.chairty.clients-carts.index', compact('carts', 'totalSum'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(donorsRequest $request) {}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cart  = Cart::query()->findOrFail($id);
        $rows = Cart::where('cookeries', $cart->cookeries)->get();
        return view('admin.dashboard.chairty.clients_carts.show', compact('cart', 'rows'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {}
}
