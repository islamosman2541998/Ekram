<?php

namespace App\Http\Controllers\Admin\Charity;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CMS\StoreRequest;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Store::query()->orderBy('id', 'DESC');

        if ($request->status  != '') {
            $query->where('status', $request->status);
        }
        if ($request->full_name  != '') {
            $query->where('full_name', 'like', '%' . $request->full_name . '%');
        }
        if ($request->email  != '') {
            $query->where('email', 'like', '%' . $request->email . '%');
        }
        if ($request->mobile  != '') {
            $query->where('mobile', 'like', '%' . $request->mobile . '%');
        }


        $store = $query->paginate($this->pagination_count);

        return view('admin.dashboard.chairty.store.index', compact('store'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.dashboard.chairty.store.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $data = $request->getSanitized();
        if ($request->hasFile('employee_image')) {
            $data['employee_image'] = $this->upload_file($request->file('employee_image'), ('stores'));
        }
        $data['password'] = bcrypt($data['password']);
        if ($request->hasFile('background_image')) {
            $data['background_image'] = $this->upload_file($request->file('background_image'), ('stores'));
        }
        Store::create($data);
        session()->flash('success', trans('message.admin.created_sucessfully'));
        if(request()->submit == "new"){ return  redirect()->back();}
        return redirect()->route('admin.store.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Store $store)
    {
        return view('admin.dashboard.chairty.store.show', compact('store'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Store $store)
    {
        return view('admin.dashboard.chairty.store.edit', compact('store'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRequest $request, Store $store)
    {
        $data = $request->getSanitized();
        if ($request->hasFile('employee_image')) {
            $this->delete_file($store->employee_image);
            $data['employee_image'] = $this->upload_file($request->file('employee_image'), ('stores'));
        }
        if ($request->hasFile('background_image')) {
            $this->delete_file($store->background_image);
            $data['background_image'] = $this->upload_file($request->file('background_image'), ('stores'));
        }
        $store->update($data);
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        if(request()->submit == "update"){ return  redirect()->back();}
        return redirect()->route('admin.store.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stores = Store::query()->with('trans')->findOrFail($id);
        $this->delete_file($stores->employee_image);
        $this->delete_file($stores->background_image);
        $stores->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }



    public function update_status($id)
    {
        $stores = Store::findOrfail($id);
        $stores->status == 1 ? $stores->status = 0 : $stores->status = 1;
        $stores->save();
        return redirect()->back();
    }

    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $stores = Store::findMany($request['record']);
            foreach ($stores as $store) {
                $store->update(['status' => 1]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $stores = Store::findMany($request['record']);
            foreach ($stores as $store) {
                $store->update(['status' => 0]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $stores = Store::findMany($request['record']);
            foreach ($stores as $store) {
                $this->delete_file($store->image);
                $store->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }
}
