<?php

namespace App\Http\Controllers\Admin\Charity;

use App\Models\Volunteers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Charity\VolunteersRequest;
use App\Models\Accounts;
use App\Models\LoginTypes;
use Illuminate\Support\Facades\DB;

class VoluntreeController extends Controller
{
    public function index(Request $request)
    {
        $query = Volunteers::query()->orderBy('id', 'DESC');

        // Type filter
        if ($request->filled('type')) {
            $type = $request->type;
            if (in_array($type, ['volunteer', '1'])) {
                $query->where('type', 'volunteer');
            } elseif (in_array($type, ['team', '0'])) {
                $query->where('type', 'team');
            }
        }

        // Status filter
        if ($request->filled('status') && in_array($request->status, ['0', '1'])) {
            $query->where('status', (int)$request->status);
        }

        // Gender filter
        if ($request->filled('gender')) {
            $gender = $request->gender;
            if (in_array($gender, ['female', '1'])) {
                $query->where('gender', '1'); // Female
            } elseif (in_array($gender, ['male', '2'])) {
                $query->where('gender', '2'); // Male
            }
        }

        // Text search fields
        $searchFields = [
            'name',
            'team_name',
            'identity',
            'mobile',
            'email',
            'nationality'
        ];

        foreach ($searchFields as $field) {
            if ($request->filled($field)) {
                $query->where($field, 'like', '%' . $request->$field . '%');
            }
        }

        // Date range filter
        if ($request->filled('search_created_from') && $request->filled('search_created__to')) {
            $query->whereBetween('created_at', [
                $request->search_created_from,
                $request->search_created__to
            ]);
        } elseif ($request->filled('search_created_from')) {
            $query->whereDate('created_at', '>=', $request->search_created_from);
        } elseif ($request->filled('search_created__to')) {
            $query->whereDate('created_at', '<=', $request->search_created__to);
        }

        $items = $query->paginate($this->pagination_count);

        return view('admin.dashboard.chairty.volunteers.index', compact('items'));
    }


    public function create()
    {
        return view('admin.dashboard.chairty.volunteers.create');
    }


    public function store(VolunteersRequest $request)
    {
        $data = $request->getSanitized();
        DB::beginTransaction();

        if ($request->hasFile('image')) {
            $data['image'] = $this->upload_file($request->file('image'), ('volunteer'));
        }
        if ($request->hasFile('team_logo')) {
            $data['team_logo'] = $this->upload_file($request->file('team_logo'), ('volunteer'));
        }

        if(!isset($data['account_id'])){
            $data['password'] = bcrypt($data['password']);
            $account = Accounts::create($data);
            $data['account_id'] = $account->id;
            $types = LoginTypes::query()->whereIn('type', $data['type_login'])->pluck('id')->toArray();
            $account->types()->attach($types);
        }
        else{
            $account = Accounts::find($data['account_id']);
            $account->user_name = $data['user_name'];
            $account->email = $data['email'];
            $account->password = isset($data['password'])? bcrypt($data['password']) : $account->password;
            $account->save();
            $types = LoginTypes::query()->whereIn('type', $data['type_login'])->pluck('id')->toArray();
            $account->types()->syncWithoutDetaching($types);
        }

        $volunteer = Volunteers::create($data);
        DB::commit();
        DB::rollBack();
        
   
        session()->flash('success', trans('message.admin.created_sucessfully'));

        if (request()->submit == "new") {
            return  redirect()->back();
        }
        return redirect()->route('admin.volunteers.index');
    }

    public function show(Volunteers $volunteer)
    {
        return view('admin.dashboard.chairty.volunteers.show', compact('volunteer'));
    }


    public function edit(Volunteers $volunteer)
    {
        return view('admin.dashboard.chairty.volunteers.edit', compact('volunteer'));
    }


    public function update(VolunteersRequest $request, Volunteers $volunteer)
    {
        $data = $request->getSanitized();

        DB::beginTransaction();

        if ($request->hasFile('image')) {
             $this->delete_file($volunteer->image);
            $data['image'] = $this->upload_file($request->file('image'), ('volunteer'));
        }
        if ($request->hasFile('team_logo')) {
             $this->delete_file($volunteer->team_logo);
            $data['team_logo'] = $this->upload_file($request->file('team_logo'), ('volunteer'));
        }


        if(!isset($data['account_id'])){
            $data['password'] = bcrypt($data['password']);
            $account = Accounts::create($data);
            $data['account_id'] = $account->id;
            $types = LoginTypes::query()->whereIn('type', $data['type_login'])->pluck('id')->toArray();
            $account->types()->attach($types);
        }
        else{
            $account = Accounts::find($data['account_id']);
            $account->user_name = $data['user_name'];
            $account->email = $data['email'];
            $account->password = isset($data['password'])? bcrypt($data['password']) : $account->password;
            $account->save();
            $types = LoginTypes::query()->whereIn('type', $data['type_login'])->pluck('id')->toArray();
            $account->types()->syncWithoutDetaching($types);
        }
        
        $volunteer->update($data);

        DB::commit();
        DB::rollBack();

        session()->flash('success', trans('message.admin.updated_sucessfully'));
        if (request()->submit == "update") {
            return  redirect()->back();
        }
        return  redirect()->route('admin.volunteers.index');
    }


    public function destroy(Volunteers $volunteer)
    {
        $this->delete_file($volunteer->image);
        $volunteer->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }



    public function update_status($id)
    {
        $volunteer = Volunteers::findOrfail($id);
        $volunteer->status == 1 ? $volunteer->status = 0 : $volunteer->status = 1;
        $volunteer->save();
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->back();
    }

    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $volunteers = Volunteers::findMany($request['record']);
            foreach ($volunteers as $volunteer) {
                $volunteer->update(['status' => 1]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $volunteers = Volunteers::findMany($request['record']);
            foreach ($volunteers as $volunteer) {
                $volunteer->update(['status' => 0]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $volunteers = Volunteers::findMany($request['record']);
            foreach ($volunteers as $volunteer) {
                $this->delete_file($volunteer->image);
                $volunteer->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }
}
