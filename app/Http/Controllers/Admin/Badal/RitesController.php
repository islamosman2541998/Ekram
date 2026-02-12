<?php

namespace App\Http\Controllers\Admin\Badal;

use App\Models\BadalRites;
use Illuminate\Http\Request;
use App\Models\CharityProject;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Badal\RitesRequest;

class RitesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = BadalRites::query()->with('trans', 'project')->orderBy('id', 'DESC');

        $projects = CharityProject::query()->with('trans')->badal()->get();

        if ($request->status  != '') {
            if ($request->status == 1) $query->where('status', $request->status);
            else {
                $query->where('status', '!=', 1);
            }
        }
        if ($request->title  != '') {
            $query = $query->orWhereTranslationLike('title', '%' . $request->title . '%');
        }
        if ($request->project_id  != '') {
            $query = $query->where('project_id', $request->project_id );
        }
        

        $items = $query->paginate($this->pagination_count);
        return view('admin.dashboard.badal.rites.index', compact('items', 'projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $badalProject = CharityProject::query()->with('trans')->badal()->get();
        return view('admin.dashboard.badal.rites.create', compact('badalProject'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RitesRequest $request)
    {
        $data = $request->getSanitized();

        if ($request->hasFile('image')) {
            $data['image'] = $this->upload_file($request->file('image'), ('rites'));
        }
        BadalRites::create($data);

        session()->flash('success', trans('message.admin.created_sucessfully'));
        if (request()->submit == "new") {
            return  redirect()->back();
        }
        return redirect()->route('admin.badal.rites.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rites = BadalRites::with('trans', 'project', 'project.trans')->findOrFail($id);
        $badalProject = CharityProject::query()->with('trans')->Badal()->get();
        return view('admin.dashboard.badal.rites.show', compact('badalProject', 'rites'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rites = BadalRites::with('trans', 'project')->findOrFail($id);
        $badalProject = CharityProject::query()->with('trans')->Badal()->get();
        return view('admin.dashboard.badal.rites.edit', compact('badalProject', 'rites'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RitesRequest $request, $id)
    {
        $data = $request->getSanitized();
        $rites = BadalRites::with('project', 'project.trans')->findOrFail($id);
        if ($request->hasFile('image')) {
            $this->delete_file($rites->image);
            $data['image'] = $this->upload_file($request->file('image'), 'rites');
        }
        $rites->update($data);
        session()->flash('success', trans('message.admin.updated_sucessfully'));

        session()->flash('success', trans('message.admin.created_sucessfully'));
        if (request()->submit == "update") {
            return  redirect()->back();
        }
        return redirect()->route('admin.badal.rites.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rites = BadalRites::findOrFail($id);
        $this->delete_file($rites->image);
        $rites->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }


    public function update_status($id)
    {
        $ritess = BadalRites::findOrfail($id);
        $ritess->status == 1 ? $ritess->status = 0 : $ritess->status = 1;
        $ritess->save();
        return redirect()->back();
    }
    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $ritess = BadalRites::findMany($request['record']);
            foreach ($ritess as $rites) {
                $ritess->update(['status' => 1]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $ritess = BadalRites::findMany($request['record']);
            foreach ($ritess as $rites) {
                $rites->update(['status' => 0]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $ritess = BadalRites::findMany($request['record']);
            foreach ($ritess as $rites) {
                $this->delete_file($rites->image);
                $rites->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }
}
