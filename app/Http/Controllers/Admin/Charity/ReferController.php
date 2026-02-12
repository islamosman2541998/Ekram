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
use App\Http\Requests\Admin\Charity\ReferRequest;

class ReferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Refer::query()->orderBy('id', 'DESC');

        if ($request->status  != '') {
            $query->where('status', $request->status);
        }
        if ($request->name  != '') {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->employee_name  != '') {
            $query->where('employee_name', 'like', '%' . $request->employee_name . '%');
        }

        $refers = $query->paginate($this->pagination_count);
        return view('admin.dashboard.chairty.refer.index', compact('refers'));
    }
    protected function buildGroupManagersTree()
    {

        $groupManagers = Refer::where('is_group_manager', true)->get()->keyBy('id');

        $childrenMap = [];
        foreach ($groupManagers as $gm) {
            $childrenMap[$gm->id] = [];
        }


        $rows = DB::table('refer_refer')
            ->whereIn('parent_id', $groupManagers->keys())
            ->whereIn('child_id', $groupManagers->keys())
            ->get();

        foreach ($rows as $r) {
            $childrenMap[$r->parent_id][] = $groupManagers->get($r->child_id);
        }

        $roots = [];
        foreach ($groupManagers as $id => $gm) {
            $hasParentInGroup = $rows->contains(function ($row) use ($id) {
                return $row->child_id == $id;
            });
            if (!$hasParentInGroup) {
                $roots[] = $gm;
            }
        }

        $build = function ($nodes) use (&$build, $childrenMap) {
            $out = [];
            foreach ($nodes as $node) {
                $kids = $childrenMap[$node->id] ?? [];
                $out[] = [
                    'node' => $node,
                    'children' => $build($kids),
                ];
            }
            return $out;
        };

        return $build($roots);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $allRefers = Refer::all();
        $managers = Manager::all();
        $groupManagersTree = $this->buildGroupManagersTree();

        return view('admin.dashboard.chairty.refer.create', compact('allRefers', 'managers', 'groupManagersTree'));
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * Generate a unique 6-letter uppercase code for Refer.
     *
     * @return string
     */
    protected function generateUniqueReferCode(int $maxAttempts = 10): string
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $len = 6;

        for ($attempt = 0; $attempt < $maxAttempts; $attempt++) {
            $code = '';
            for ($i = 0; $i < $len; $i++) {
                $code .= $alphabet[random_int(0, strlen($alphabet) - 1)];
            }

            if (!Refer::where('code', $code)->exists()) {
                return $code;
            }
        }

        throw new \RuntimeException('Unable to generate a unique refer code after ' . $maxAttempts . ' attempts.');
    }
 public function store(ReferRequest $request)
{
    $data = $request->getSanitized();

    DB::beginTransaction();
    try {
        // upload image if exists
        if ($request->hasFile('employee_image')) {
            $data['employee_image'] = $this->upload_file($request->file('employee_image'), 'refer');
        }

        // create / update associated account
        if (!isset($data['account_id'])) {
            $data['password'] = bcrypt($data['password']);
            $account = Accounts::create($data);
            $data['account_id'] = $account->id;
            $types = LoginTypes::whereIn('type', $data['type'])->pluck('id')->toArray();
            $account->types()->attach($types);
        } else {
            $account = Accounts::find($data['account_id']);
            $account->email = $data['email'];
            $account->user_name = $data['user_name'];
            $account->password = isset($data['password']) ? bcrypt($data['password']) : $account->password;
            $account->save();
        }

        // flags and generated code
        $data['is_group_manager'] = $request->boolean('is_group_manager');
        $data['code'] = $this->generateUniqueReferCode();

        // create refer
        $newRefer = Refer::create($data);

        // link supervisor (parent) if provided and gather parent's managers
        $supervisorId = $request->input('supervisor_id');
        $parentManagers = [];
        if ($supervisorId) {
            $parent = Refer::find($supervisorId);
            if ($parent) {
                // attach this refer as child of parent (without removing others)
                $parent->children()->syncWithoutDetaching([$newRefer->id]);

                // inherit parent's managers (pluck correct id)
                $parentManagers = $parent->managers()->pluck('managers.id')->toArray();
            }
        }

        // manager from form (single)
        $formManagerId = $request->input('manager_id');
        $allManagers = [];
        if ($formManagerId) {
            $allManagers[] = (int) $formManagerId;
        }

        // merge with parent managers and ensure unique
        $allManagers = array_values(array_unique(array_merge($allManagers, $parentManagers)));

        // sync managers (single or inherited)
        if (!empty($allManagers)) {
            $newRefer->managers()->sync($allManagers);
        } else {
            $newRefer->managers()->sync([]); // ensure none attached if none provided
        }

        // children from form
        $newRefer->children()->sync($request->input('children', []));

        DB::commit();
        session()->flash('success', trans('message.admin.created_sucessfully'));

        if (request()->submit == "new") {
            return redirect()->back();
        }

        return redirect()->route('admin.charity.refers.index');
    } catch (\Exception $e) {
        DB::rollBack();
        logger()->error('Refer create failed: ' . $e->getMessage());
        return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
    }
}


    /**
     * Display the specified resource.
     */
    public function show(Refer $refer)
    {

        $refer->load([
            'managers',
            'parents' => function ($q) {
                $q->where('is_group_manager', 1);
            }
        ]);

        $supervisors = $refer->parents->where('is_group_manager', 1);

        return view('admin.dashboard.chairty.refer.show', compact('refer', 'supervisors'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Refer $refer)
    {
        $allRefers    = Refer::where('id', '!=', $refer->id)->get();
        $selectedchildren = $refer->children->pluck('id')->toArray();
        $managers = Manager::all();
        $selectedManager = $refer->managers->pluck('id')->first() ?? null;
        $groupManagersTree = $this->buildGroupManagersTree();
         $selectedSupervisor = $refer->parents()
        ->where('is_group_manager', 1)
        ->pluck('id')
        ->first() ?? null;

        return view('admin.dashboard.chairty.refer.edit', compact('refer', 'allRefers', 'selectedchildren', 'managers', 'selectedManager', 'groupManagersTree', 'selectedSupervisor'));
    }


    public function managers(Request $request)
    {
        $query = Refer::query()->where('is_group_manager', 1)->orderBy('id', 'DESC');
        if ($request->status  != '') {
            $query->where('status', $request->status);
        }
        if ($request->name  != '') {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->employee_name  != '') {
            $query->where('employee_name', 'like', '%' . $request->employee_name . '%');
        }

        $refers = $query->paginate($this->pagination_count);
        $groupManagersTree = $this->buildGroupManagersTree();

        return view('admin.dashboard.chairty.refer.index', compact('refers', 'groupManagersTree'))->with('onlyManagers', true);
    }

    /**
     * Update the specified resource in storage.
     */
  public function update(ReferRequest $request, Refer $refer)
{
    $data = $request->getSanitized();

    DB::beginTransaction();
    try {
        // image replace
        if ($request->hasFile('employee_image')) {
            $this->delete_file($refer->employee_image);
            $data['employee_image'] = $this->upload_file($request->file('employee_image'), 'refer');
        }

        // account create or update
        if (!isset($data['account_id'])) {
            $data['password'] = bcrypt($data['password']);
            $account = Accounts::create($data);
            $data['account_id'] = $account->id;
            $types = LoginTypes::whereIn('type', $data['type'])->pluck('id')->toArray();
            $account->types()->attach($types);
        } else {
            $account = Accounts::find($data['account_id']);
            $account->user_name = $data['user_name'];
            $account->email = $data['email'];
            $account->password = isset($data['password']) ? bcrypt($data['password']) : $account->password;
            $account->save();

            $types = LoginTypes::whereIn('type', $data['type'])->pluck('id')->toArray();
            $account->types()->syncWithoutDetaching($types);
        }

        // flag and update refer fields
        $data['is_group_manager'] = $request->boolean('is_group_manager');
        $refer->update($data);

        // detach existing group-manager parents (if needed)
        $existingParents = $refer->parents()->where('is_group_manager', 1)->pluck('id')->toArray();
        if (!empty($existingParents)) {
            $refer->parents()->detach($existingParents);
        }

        // supervisor changed: attach new parent and inherit its managers
        $supervisorId = $request->input('supervisor_id');
        $parentManagers = [];
        if ($supervisorId) {
            $parent = Refer::find($supervisorId);
            if ($parent) {
                $parent->children()->syncWithoutDetaching([$refer->id]);
                $parentManagers = $parent->managers()->pluck('managers.id')->toArray();
            }
        }

        // manager from form (single)
        $formManagerId = $request->input('manager_id');
        $formManagers = $formManagerId ? [(int)$formManagerId] : [];

        // merge and sync managers
        $allManagers = array_values(array_unique(array_merge($formManagers, $parentManagers)));
        if (!empty($allManagers)) {
            $refer->managers()->sync($allManagers);
        } else {
            $refer->managers()->sync([]); // unassign all if none
        }

        // sync children
        $refer->children()->sync($request->input('children', []));

        DB::commit();
        session()->flash('success', trans('message.admin.updated_sucessfully'));

        if (request()->submit == "update") {
            return redirect()->back();
        }
        return redirect()->route('admin.charity.refers.index');
    } catch (\Exception $e) {
        DB::rollBack();
        logger()->error('Refer update failed: ' . $e->getMessage());
        return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $refer = Refer::query()->findOrFail($id);
        $this->delete_file($refer->employee_image);
        $refer->delete();

        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return  redirect()->back();
    }


    public function update_status($id)
    {
        $refers = Refer::findOrfail($id);
        $refers->status == 1 ? $refers->status = 0 : $refers->status = 1;
        $refers->save();
        return redirect()->back();
    }


    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $refers = Refer::findMany($request['record']);
            foreach ($refers as $refer) {
                $refer->update(['status' => 1]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $refers = Refer::findMany($request['record']);
            foreach ($refers as $refer) {
                $refer->update(['status' => 0]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $refers = Refer::findMany($request['record']);
            foreach ($refers as $refer) {
                $refer->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }



    public function orders() {}
}
