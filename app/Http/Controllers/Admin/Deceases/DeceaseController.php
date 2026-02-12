<?php

namespace App\Http\Controllers\Admin\Deceases;

use App\Models\Decease;
use App\Models\CharityTag;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\CharityProject;
use App\Models\CategoryProjects;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Deceases\DeceasesRequest;

class DeceaseController extends Controller
{
    protected $pagination_count = 15;

    public function index()
    {
        $query = Decease::query()->with('project')->orderBy('id', 'DESC');

        // Search by name
        if (request()->filled('search_name')) {
            $query->where('name', 'LIKE', '%' . request('search_name') . '%');
        }

        // Search by deceased name
        if (request()->filled('search_deceased_name')) {
            $query->where('deceased_name', 'LIKE', '%' . request('search_deceased_name') . '%');
        }

        // Search by mobile
        if (request()->filled('search_mobile')) {
            $query->where('mobile', 'LIKE', '%' . request('search_mobile') . '%');
        }

        // Search by email
        if (request()->filled('search_email')) {
            $query->where('email', 'LIKE', '%' . request('search_email') . '%');
        }

        // Filter by status
        if (request()->filled('status')) {
            $query->where('status', request('status'));
        }

        $decease = $query->paginate($this->pagination_count);
        
        return view('admin.dashboard.deceases.request.index', compact('decease'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $charity_projects = CharityProject::query()->normal()->with('trans')->get();
        return view('admin.dashboard.deceases.request.create', compact('charity_projects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeceasesRequest $request)
    {
        $data = $request->getSanitized();

        if ($request->hasFile('image')) {
            $data['image'] = $this->upload_file($request->file('image'), 'deceases', "1");
        }
        if ($request->hasFile('deceased_image')) {
            $data['deceased_image'] = $this->upload_file($request->file('deceased_image'), 'deceases', "2");
        }
        Decease::create($data);
        session()->flash('success', trans('message.admin.created_sucessfully'));
        if(request()->submit == "new"){ return  redirect()->back();}
        return redirect()->route('admin.deceases.request.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $decease = Decease::query()->with('project')->findOrFail($id);
        $data['decease'] = $decease;
        $project = $decease->project;
        $project->deceased_id = $decease->id;
        $project->target_price = $decease->target_price;
        $project->featuer = 0;
        $project->hidden = 0;
        $project->finished = 0;
        $data['project'] =  $project;
        
        $data['categories'] = CategoryProjects::query()->with('trans')->get('id');
        $data['tags'] = CharityTag::query()->with('trans')->get('id');
        $data['payments'] = PaymentMethod::query()->active()->with('trans')->get('id');
        $data['donation'] = json_decode($data['project']->donation_type, true);

        return view('admin.dashboard.deceases.request.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Decease $decease)
    {
        $this->delete_file($decease->image);
        $decease->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }


    //Method Update status
    public function update_status($id)
    {
        $decease = Decease::findOrfail($id);
        $decease->status == 1 ? $decease->status = 0 : $decease->status = 1;
        $decease->save();
        return redirect()->back();
    }
    // Method Update All Status And delete All
    // Delete All

    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $decease = Decease::findMany($request['record']);
            foreach ($decease as $deceas) {
                $deceas->update(['status' => 1]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $decease = Decease::findMany($request['record']);
            
            foreach ($decease as $deceas) {
                $deceas->status = 0;
                $deceas->save();
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $decease = Decease::findMany($request['record']);
            foreach ($decease as $deceas) {
                $this->delete_file($deceas->image);
                $this->delete_file($deceas->deceased_image);
                $deceas->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }
}
