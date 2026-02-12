<?php

namespace App\Http\Controllers\Admin\Charity;

use App\Models\Refer;
use App\Models\Manager;
use App\Models\Accounts;
use App\Models\LoginTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\Charity\ManagerRequest;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Manager::query()->with('account')->orderBy('id', 'DESC');

        if ($request->status  != '') {
            $query->where('status', $request->status);
        }
        if ($request->name  != '') {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->email  != '') {
            $query->whereHas('account', function($q) use($request){
                $q->where('email', 'like', '%' . $request->email . '%');
            });
        }
        if ($request->mobile  != '') {
            $query->whereHas('account', function($q) use($request){
                $q->where('mobile', 'like', '%' . $request->mobile . '%');
            });
        }
        $managers = $query->paginate($this->pagination_count);
        return view('admin.dashboard.chairty.manager.index', compact('managers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $refers = Refer::get();
        return view('admin.dashboard.chairty.manager.create', compact('refers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ManagerRequest $request)
    {
        $data = $request->getSanitized();
        DB::beginTransaction();

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
            $account->user_name = $data['user_name'];
            $account->password = isset($data['password'])? bcrypt($data['password']) : $account->password;
            $account->save();
        }

        $manager = Manager::create($data);
        $manager->refers()->attach(@$data['refers']);
        DB::commit();
        DB::rollBack();

        session()->flash('success', trans('message.admin.created_sucessfully'));
        if (request()->submit == "new") {
            return  redirect()->back();
        }
        return redirect()->route('admin.charity.managers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Manager $manager)
    {
        return view('admin.dashboard.chairty.manager.show', compact('manager'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Manager $manager)
    {
        $refers = Refer::get();
        return view('admin.dashboard.chairty.manager.edit', compact('manager', 'refers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ManagerRequest $request, Manager $manager)
    {
        $data = $request->getSanitized();
        DB::beginTransaction();

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
            $types = LoginTypes::query()->whereIn('type', $data['type'])->pluck('id')->toArray();
            $account->types()->syncWithoutDetaching($types);
        }
        
        $manager->update($data);
        $manager->refers()->sync(@$data['refers']);

        session()->flash('success', trans('message.admin.updated_sucessfully'));
        DB::commit();
        DB::rollBack();

        if (request()->submit == "update") {
            return  redirect()->back();
        }
        return redirect()->route('admin.charity.managers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $manager = Manager::query()->findOrFail($id)->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return  redirect()->back();
    }

    public function update_status($id)
    {
        $manager = Manager::findOrfail($id);
        $manager->status == 1 ? $manager->status = 0 : $manager->status = 1;
        $manager->save();
        return redirect()->back();
    }


    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $managers = Manager::findMany($request['record']);
            foreach ($managers as $manager) {
                $manager->update(['status' => 1]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $managers = Manager::findMany($request['record']);
            foreach ($managers as $manager) {
                $manager->update(['status' => 0]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $managers = Manager::findMany($request['record']);
            foreach ($managers as $manager) {
                $manager->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }
}
