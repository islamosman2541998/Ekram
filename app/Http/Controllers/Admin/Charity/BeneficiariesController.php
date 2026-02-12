<?php

namespace App\Http\Controllers\Admin\Charity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Charity\BeneficiariesRequest;
use App\Models\Accounts;
use App\Models\Beneficiaries;
use App\Models\LoginTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BeneficiariesController extends Controller
{
    public function index(Request $request)
    {
        $query = Beneficiaries::query()->orderBy('id', 'DESC');

        if ($request->status != '') {
            $query->where('status', $request->status);
        }
        if ($request->first_name != '') {
            $query->where('first_name', 'like', '%' . $request->first_name . '%');
        }
        if ($request->last_name != '') {
            $query->where('last_name', 'like', '%' . $request->last_name . '%');
        }
        if ($request->email != '') {
            $query->where('email', 'like', '%' . $request->email . '%');
        }
        if ($request->phone != '') {
            $query->where('phone', 'like', '%' . $request->phone . '%');
        }
        if ($request->gender != '') {
            $query->where('gender', $request->gender);
        }
        if ($request->nationality != '') {
            $query->where('nationality', 'like', '%' . $request->nationality . '%');
        }
        if ($request->search_created_from != '') {
            $query = $query->whereDate('created_at', '>=', $request->search_created_from);
        }
        if ($request->search_created__to != '') {
            $query = $query->whereDate('created_at', '<=', $request->search_created__to);
        }

        $items = $query->paginate($this->pagination_count);

        return view('admin.dashboard.chairty.beneficiaries.index', compact('items'));
    }

    public function create()
    {
        return view('admin.dashboard.chairty.beneficiaries.create');
    }

    public function store(BeneficiariesRequest $request)
    {
        $data = $request->getSanitized();
        DB::beginTransaction();

        if(!isset($data['account_id'])){
            $data['password'] = bcrypt($data['password']);
            $account = Accounts::create($data);
            $data['account_id'] = $account->id;
            $types = LoginTypes::query()->whereIn('type', $data['type_login'])->pluck('id')->toArray();
            $account->types()->attach($types);
        } else {
            $account = Accounts::find($data['account_id']);
            $account->user_name = $data['user_name'];
            $account->email = $data['email'];
            $account->password = isset($data['password']) ? bcrypt($data['password']) : $account->password;
            $account->save();
            $types = LoginTypes::query()->whereIn('type', $data['type_login'])->pluck('id')->toArray();
            $account->types()->syncWithoutDetaching($types);
        }

        $beneficiary = Beneficiaries::create($data);
        DB::commit();
        DB::rollBack();

        session()->flash('success', trans('message.admin.created_sucessfully'));

        if (request()->submit == "new") {
            return redirect()->back();
        }
        return redirect()->route('admin.beneficiaries.index');
    }

    public function show(Beneficiaries $beneficiary)
    {
        return view('admin.dashboard.chairty.beneficiaries.show', compact('beneficiary'));
    }

    public function edit(Beneficiaries $beneficiary)
    {
        return view('admin.dashboard.chairty.beneficiaries.edit', compact('beneficiary'));
    }

    public function update(BeneficiariesRequest $request, Beneficiaries $beneficiary)
    {
        $data = $request->getSanitized();

        DB::beginTransaction();

        if(!isset($data['account_id'])){
            $data['password'] = bcrypt($data['password']);
            $account = Accounts::create($data);
            $data['account_id'] = $account->id;
            $types = LoginTypes::query()->whereIn('type', $data['type_login'])->pluck('id')->toArray();
            $account->types()->attach($types);
        } else {
            $account = Accounts::find($data['account_id']);
            $account->user_name = $data['user_name'];
            $account->email = $data['email'];
            $account->password = isset($data['password']) ? bcrypt($data['password']) : $account->password;
            $account->save();
            $types = LoginTypes::query()->whereIn('type', $data['type_login'])->pluck('id')->toArray();
            $account->types()->syncWithoutDetaching($types);
        }

        $beneficiary->update($data);

        DB::commit();
        DB::rollBack();

        session()->flash('success', trans('message.admin.updated_sucessfully'));
        if (request()->submit == "update") {
            return redirect()->back();
        }
        return redirect()->route('admin.beneficiaries.index');
    }

    public function destroy(Beneficiaries $beneficiary)
    {
        $beneficiary->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }

    public function update_status($id)
    {
        $beneficiary = Beneficiaries::findOrFail($id);
        $beneficiary->status = !$beneficiary->status;
        $beneficiary->save();
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->back();
    }

    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $beneficiaries = Beneficiaries::findMany($request['record']);
            foreach ($beneficiaries as $beneficiary) {
                $beneficiary->update(['status' => 1]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $beneficiaries = Beneficiaries::findMany($request['record']);
            foreach ($beneficiaries as $beneficiary) {
                $beneficiary->update(['status' => 0]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $beneficiaries = Beneficiaries::findMany($request['record']);
            foreach ($beneficiaries as $beneficiary) {
                $beneficiary->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }
}