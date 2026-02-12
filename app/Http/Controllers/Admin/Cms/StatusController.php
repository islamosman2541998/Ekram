<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CMS\StatuRequest;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Status::query()->with('trans')->orderBy('id', 'DESC');
        if ($request->status  != '') {
            $query->where('status', $request->status);
        }
        if ($request->title  != '') {
            $query->orWhereTranslationLike('title', '%' . $request->title . '%');
        }
        if ($request->description != '') {
            $query->orWhereTranslationLike('description', '%' . $request->title . '%');
        }
        $items = $query->paginate($this->pagination_count);
        return view('admin.dashboard.cms.status.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.dashboard.cms.status.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StatuRequest $request)
    {
        $data = $request->getSanitized();
        Status::create($data);
        session()->flash('success', trans('message.admin.created_sucessfully'));
        if (request()->submit == "new") {
            return  redirect()->back();
        }
        return redirect()->route('admin.status.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show(Status $status)
    {
        return view('admin.dashboard.cms.status.show', compact('status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit(Status $status)
    {
        return view('admin.dashboard.cms.status.edit', compact('status'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StatuRequest $request, Status $status)
    {
        $data = $request->getSanitized();
        $status->update($data);

        session()->flash('success', trans('message.admin.updated_sucessfully'));
        if(request()->submit == "update"){ return  redirect()->back();}
        return  redirect()->route('admin.status.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Status $status)
    {
        $status->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }


    //Method Update status
    public function update_status($id)
    {
        $Status = Status::find($id);
        $Status->status == 1 ? $Status->status = 0 : $Status->status = 1;
        $Status->save();
        return redirect()->back();
    }


    // Method Update All Status And delete All
    // Delete All 

    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $Status = Status::findMany($request['record']);
            foreach ($Status as $Statu) {
                $Statu->update(['status' => 1]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $Status = Status::findMany($request['record']);
            foreach ($Status as $Statu) {
                $Statu->update(['status' => 0]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $Status = Status::findMany($request['record']);
            foreach ($Status as $Statu) {

                $Statu->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }
}
