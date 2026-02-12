<?php

namespace App\Http\Controllers\Admin\Badal;

use App\Models\Accounts;
use App\Models\LoginTypes;
use App\Models\Substitutes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Badal\SubstituteRequest;
use Illuminate\Support\Facades\DB;

class SubstituteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('admin.dashboard.badal.substitutes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.dashboard.badal.substitutes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubstituteRequest $request)
    {
        $data = $request->getSanitized();
        DB::beginTransaction();
        try {
            if ($request->hasFile('image')) {
                $data['image'] = $this->upload_file($request->file('image'), ('substitutes'));
            }

            if (!isset($data['account_id'])) {
                $data['password'] = bcrypt($data['password']);
                $account = Accounts::create($data);
                $data['account_id'] = $account->id;
                $types = LoginTypes::query()->whereIn('type', $data['type'])->pluck('id')->toArray();
                $account->types()->attach($types);
            } else {
                $account = Accounts::find($data['account_id']);
                $account->email = $data['email'];
                $account->user_name = $data['user_name'];
                $account->password = isset($data['password']) ? bcrypt($data['password']) : $account->password;
                $account->save();
            }

            $substitutes = Substitutes::create($data);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
        session()->flash('success', trans('message.admin.created_sucessfully'));
        if (request()->submit == "new") {
            return  redirect()->back();
        }
        return redirect()->route('admin.badal.substitutes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $substitute = Substitutes::query()->findOrFail($id);
        return view('admin.dashboard.badal.substitutes.show', compact('substitute'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $substitute = Substitutes::query()->findOrFail($id);
        return view('admin.dashboard.badal.substitutes.edit', compact('substitute'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubstituteRequest $request, $id)
    {
        $substitute = Substitutes::findOrFail($id);
        $data = $request->getSanitized();
        DB::beginTransaction();
        try {   
            if ($request->hasFile('image')) {
                $this->delete_file($substitute->image);
                $data['image'] = $this->upload_file($request->file('image'), ('substitute'));
            }

            if (!isset($data['account_id'])) {
                $data['password'] = bcrypt($data['password']);
                $account = Accounts::create($data);
                $data['account_id'] = $account->id;
                $types = LoginTypes::query()->whereIn('type', $data['type'])->pluck('id')->toArray();
                $account->types()->attach($types);
            } else {
                $account = Accounts::find($data['account_id']);
                $account->user_name = $data['user_name'];
                $account->email = $data['email'];
                $account->password = isset($data['password']) ? bcrypt($data['password']) : $account->password;
                $account->save();
    
                $types = LoginTypes::query()->whereIn('type', $data['type'])->pluck('id')->toArray();
                $account->types()->syncWithoutDetaching($types);
            }
            $substitute->update($data);
            
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }

        session()->flash('success', trans('message.admin.updated_sucessfully'));
        if (request()->submit == "update") {
            return  redirect()->back();
        }
        return redirect()->route('admin.badal.substitutes.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $substitute = Substitutes::findOrFail($id)->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return  redirect()->back();
    }

    public function update_status($id)
    {
        $substitute = Substitutes::findOrfail($id);
        $substitute->status == 1 ? $substitute->status = 0 : $substitute->status = 1;
        $substitute->save();
        return redirect()->back();
    }

    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $substitutes = Substitutes::findMany($request['record']);
            foreach ($substitutes as $substitute) {
                $substitute->update(['status' => 1]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $substitutes = Substitutes::findMany($request['record']);
            foreach ($substitutes as $substitute) {
                $substitute->update(['status' => 0]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $substitutes = Substitutes::findMany($request['record']);
            foreach ($substitutes as $substitute) {
                $this->delete_file($substitute->image);
                $substitute->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }
}
