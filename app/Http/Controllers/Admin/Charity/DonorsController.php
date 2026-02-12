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

class DonorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Donor::query()->orderBy('id', 'DESC');
        

        if ($request->status  != '') {
            $query->where('status', $request->status);
        }
        if ($request->name  != '') {
            $query->where('full_name', 'like', '%' . $request->name . '%');
        }
        if ($request->email  != '') {
            $query->whereHas('account', function($q){
            $q->where('email', 'like', '%' . request()->email . '%');
            });
        }
        if ($request->mobile  != '') {
            $query->whereHas('account', function($q){
            $q->where('mobile', 'like', '%' . request()->mobile . '%');
            });
        }
        $donor = $query->paginate($this->pagination_count);
        return view('admin.dashboard.chairty.donor.index', compact('donor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $refers = Refer::orderBy('id', 'DESC')->get();
        return view('admin.dashboard.chairty.donor.create', compact('refers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(donorsRequest $request)
    {
        $data = $request->getSanitized();
        if ($request->hasFile('image')) {
            $data['image'] = $this->upload_file($request->file('image'), ('donors'));
        }
        if(!isset($data['account_id'])){
            // $data['password'] = bcrypt($data['password']);
            $account = Accounts::create($data);
            $data['account_id'] = $account->id;
            $types = LoginTypes::query()->whereIn('type', $data['type'])->pluck('id')->toArray();
            $account->types()->attach($types);
        }
        else{
            $account = Accounts::find($data['account_id']);
            $account->email = $data['email'];
            $account->user_name = $data['user_name'];
            $account->password = isset($data['password'])? bcrypt($data['password']) : $account->password;
            $account->save();
        }

        $donor = Donor::create($data);
        // $donor_id = $donor->where('id', $donor->id)->first('id');
        if (isset($data['addressList'])) {
            foreach ($data['addressList'] as $address) {
                $address_donor =  new AddressDonor();
                $address_donor->city = $address['city'];
                $address_donor->country = $address['country'];
                $address_donor->address = $address['address'];
                $address_donor->doner_id = $donor->id;
                $address_donor->save();
            }
        }
        session()->flash('success', trans('message.admin.created_sucessfully'));
        if (request()->submit == "new") {
            return  redirect()->back();
        }
        return redirect()->route('admin.donors.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $donor = Donor::query()->findOrFail($id);
        return view('admin.dashboard.chairty.donor.show', compact('donor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $donor = Donor::query()->findOrFail($id);
        $refers = Refer::orderBy('id', 'DESC')->get();
        return view('admin.dashboard.chairty.donor.edit', compact('donor', 'refers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(donorsRequest $request, $id)
    {
        // query donor table with relations addressDonor
        $donor = Donor::query()->with('addressDonor')->findOrFail($id);
        // $donor = Donor::query()->findOrFail($id)->first();
        $address_donor = AddressDonor::query();
        $data = $request->getSanitized();
        if ($request->hasFile('image')) { 
            $this->delete_file($donor->image);
            $data['image'] = $this->upload_file($request->file('image'), ('donors'));
        }
        
        if(!isset($data['account_id'])){
            $data['password'] = bcrypt($data['password']);
            $account = Accounts::create($data);
            $data['account_id'] = $account->id;
            $types = LoginTypes::query()->whereIn('type', $data['type'])->pluck('id')->toArray();
            $account->types()->attach($types);
        }
        else{
            $account = Accounts::find($data['account_id']);
            $account->email = $data['email'];
            $account->password = isset($data['password'])? bcrypt($data['password']) : $account->password;
            $account->save();
            $types = LoginTypes::query()->whereIn('type', $data['type'])->pluck('id')->toArray();
            $account->types()->syncWithoutDetaching($types);
        }

        $donor->update($data);

        if (@$data['old'] != null) {
            foreach (@$data['old']['id'] as $key => $old) {
                $address = AddressDonor::find($old);
                $address->city = @$data['old']['city'][$key];
                $address->country = @$data['old']['country'][$key];
                $address->address = @$data['old']['address'][$key];
                $address->save();
            }
        }
        $address = $donor->addressDonor;
        $removeAddress = AddressDonor::query()->whereIn('id', $donor->addressDonor->pluck('id')->toArray())->WhereNotIN('id', @$data['old']['id']  ?? [])->delete();
        if ($request->addressList != null) {
            foreach ($data['addressList'] as $item) { 
                if( $item['city'] != null || $item['country'] != null || $item['address'] != null){
                    $address_donor->create([
                        'city' => $item['city'],
                        'country' => $item['country'],
                        'address' => $item['address'],
                        'doner_id' => $donor->id,
                    ]);
                }
            }
            session()->flash('success', trans('message.admin.updated_sucessfully'));
        }
        if (request()->submit == "update") {
            return  redirect()->back();
        }
        return redirect()->route('admin.donors.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Donor::query()->with('addressDonor')->findOrFail($id)->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return  redirect()->back();
    }

    public function update_status($id)
    {
        $donors = Donor::findOrfail($id);
        $donors->status == 1 ? $donors->status = 0 : $donors->status = 1;
        $donors->save();
        return redirect()->back();
    }

    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $donors = Donor::findMany($request['record']);
            foreach ($donors as $donor) {
                $donor->update(['status' => 1]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $donors = Donor::findMany($request['record']);
            foreach ($donors as $donor) {
                $donor->update(['status' => 0]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $donors = Donor::findMany($request['record']);
            foreach ($donors as $donor) {
                $this->delete_file($donor->image);
                $donor->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }
}
