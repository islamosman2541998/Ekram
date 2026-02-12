<?php

namespace App\Http\Controllers\Admin\Products;

use session;
use App\Models\Vendor;
use App\Models\Accounts;
use App\Models\LoginTypes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\VendorRequest;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Vendor::query()->with('trans')->orderBy('id', 'DESC');

        if ($request->status  != '') {
            $query->where('status', $request->status);
        }
        if ($request->title  != '') {
            $query = $query->orWhereTranslationLike('title', '%' . request()->input('title') . '%');
        }
        if ($request->responsible_person  != '') {
            $query->where('responsible_person', 'like', '%' . $request->responsible_person . '%');
        }
        if ($request->email  != '') {
            $query->where('email', 'like', '%' . $request->email . '%');
        }
        if ($request->mobile  != '') {
            $query->where('mobile', 'like', '%' . $request->mobile . '%');
        }
        $vendor = $query->paginate($this->pagination_count);

        return view('admin.dashboard.products.vendor.index', compact('vendor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.dashboard.products.vendor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VendorRequest $request)
    {
        $data = $request->getSanitized();

        if ($request->hasFile('logo')) {
            $data['logo'] = $this->upload_file($request->file('logo'), ('vendor'));
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
            $account->user_name = $data['user_name'];
            $account->email = $data['email'];
            $account->password = isset($data['password'])? bcrypt($data['password']) : $account->password;
            $account->save();
        }

        Vendor::create($data);
        session()->flash('success', trans('message.admin.created_sucessfully'));
        if(request()->submit == "new"){ return  redirect()->back();}
        return redirect()->route('admin.eccommerce.vendors.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Vendor $vendor)
    {
        return view('admin.dashboard.products.vendor.show', compact('vendor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Vendor $vendor)
    {
        return view('admin.dashboard.products.vendor.edit', compact('vendor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VendorRequest $request, Vendor $vendor)
    {
        $data = $request->getSanitized();
        if ($request->hasFile('logo')) {
            $this->delete_file($vendor->logo);
            $data['logo'] = $this->upload_file($request->file('logo'), ('vendor'));
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

        $vendor->update($data);

        session()->flash('success', trans('message.admin.updated_sucessfully'));
        if (request()->submit == "update") {  return  redirect()->back(); }
        return redirect()->route('admin.eccommerce.vendors.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendor $vendor)
    {
        $this->delete_file($vendor->logo);
        $vendor->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }
    //Method Update status
    public function update_status($id)
    {
        $vendor = Vendor::findOrfail($id);
        $vendor->status == 1 ? $vendor->status = 0 : $vendor->status = 1;
        $vendor->save();
        return redirect()->back();
    }
    // Method Update Featured
    public function update_featured($id)
    {
        $vendor = Vendor::findOrfail($id);
        $vendor->feature == 1 ? $vendor->feature = 0 : $vendor->feature = 1;
        $vendor->save();
        return redirect()->back();
    }

    // Method Update All Status And delete All
    // Delete All

    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $vendors = Vendor::findMany($request['record']);
            foreach ($vendors as $vendor) {
                $vendor->update(['status' => 1]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $vendors = Vendor::findMany($request['record']);
            foreach ($vendors as $vendor) {
                $vendor->update(['status' => 0]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $vendors = Vendor::findMany($request['record']);
            foreach ($vendors as $vendor) {
                $this->delete_file($vendor->logo);
                $vendor->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }
}
