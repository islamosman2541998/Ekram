<?php

namespace App\Http\Controllers\Admin\Charity;

use App\Models\Review;
use App\Models\Decease;
use App\Models\CharityTag;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\CharityProject;
use App\Models\CategoryProjects;
use App\Http\Controllers\Controller;
use App\Models\CharitySingleProject;
use App\Http\Requests\Admin\Charity\CharitySingleProjectRequest;

class CharitySingleProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dashboard.chairty.single-project.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['categories'] = CategoryProjects::query()->single()->with('trans')->get('id');
        $data['tags'] = CharityTag::query()->with('trans')->get('id');
        $data['payments'] = PaymentMethod::query()->with('trans')->get('id');
        if ($data['categories']->first() == null) {
            session()->flash('error', trans('message.admin.please_create_category_first'));
            return redirect(route('admin.charity.categories.create'));
        }
        if ($data['payments']->first() == null) {
            session()->flash('error', trans('message.admin.please_create_payment_method_first'));
            return redirect(route('admin.payment-method.create'));
        }
        return view('admin.dashboard.chairty.single-project.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CharitySingleProjectRequest $request)
    {
        $data = $request->getSanitized();
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $this->upload_file($request->file('cover_image'), ('Charity_Project'), '1');
        }
        if ($request->hasFile('background_image')) {
            $data['background_image'] = $this->upload_file($request->file('background_image'), ('Charity_Project'), '2');
        }

        // Save donation_type
        $data['donation_type'] = ProjectType($data);

        // check the request is badel to save
        $charity_project =  CharityProject::create($data);
        $data['single']['project_id'] = $charity_project->id;
        CharitySingleProject::create($data['single']);
        // insert to table charity_project_tags
        if (request()->tags != null) {
            $charity_project->tags()->attach(request()->tags);
        }

        // insert to table charity_payment_projects
        if (request()->payment_method != null) {
            $charity_project->payment()->attach(request()->payment_method);
        }
        session()->flash('success', trans('message.admin.created_sucessfully'));
        if (request()->submit == "new") {
            return  redirect()->back();
        }
        return redirect()->route('admin.charity.single-projects.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['items'] =  CharityProject::query()->with('trans')->findOrFail($id);
        $data['donation'] = json_decode($data['items']->donation_type, true);
        $data['categories'] = CategoryProjects::query()->with('trans')->single()->get('id');
        $data['tags'] = CharityTag::query()->with('trans')->get('id');
        $data['payments'] = PaymentMethod::query()->with('trans')->get('id');
        return view('admin.dashboard.chairty.single-project.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['project'] =  CharityProject::query()->with(['trans', 'singleField'])->single()->findOrFail($id);
        $data['categories'] = CategoryProjects::query()->with('trans')->get('id');
        $data['tags'] = CharityTag::query()->with('trans')->get('id');
        $data['payments'] = PaymentMethod::query()->with('trans')->get('id');
        $data['donation'] = json_decode($data['project']->donation_type, true);
        return view('admin.dashboard.chairty.single-project.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CharitySingleProjectRequest $request, $id)
    {
        $items = CharityProject::query()->with('trans')->findOrFail($id);
        $data = $request->getSanitized();
        if ($request->hasFile('cover_image')) {
            $this->delete_file($items->cover_image);
            $data['cover_image'] = $this->upload_file($request->file('cover_image'), ('Charity_Project'), '1');
        }
        if ($request->hasFile('background_image')) {
            $this->delete_file($items->background_image);
            $data['background_image'] = $this->upload_file($request->file('background_image'), ('Charity_Project'), '2');
        }

        // Save donation_type
        $data['donation_type'] = ProjectType($data);

        $items->update($data);
        $items->singleField->update($data['single']);
        // insert to table charity_project_tags
        if (request()->tags != null) {
            $items->tags()->sync(request()->tags);
        }
        // insert to table charity_payment_projects
        if (request()->payment_method != null) {
            $items->payment()->sync(request()->payment_method);
        }

        session()->flash('success', trans('message.admin.updated_sucessfully'));
        if (request()->submit == "update") {
            return  redirect()->back();
        }
        return redirect()->route('admin.charity.single-projects.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function reviews(Request $request, $id)
    {
        $charity_project = CharityProject::query()->with('reviews')->findOrFail($id);

        $reviews = $charity_project->reviews;
        if ($request->rate != '') {
            $reviews = $reviews->where('rate', $request->rate);
        }
        if ($request->created_by != '') {
            $reviews = $reviews->where('created_by', $request->created_by);
        }
        return view('admin.dashboard.chairty.project.review', compact('charity_project', 'reviews'));
    }

    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $reviews = Review::findMany($request['record']);
            foreach ($reviews as $review) {
                $review->update(['status' => 1]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $reviews = Review::findMany($request['record']);
            foreach ($reviews as $review) {
                $review->update(['status' => 0]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $reviews = Review::findMany($request['record']);
            foreach ($reviews as $review) {
                $review->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }

    public function update_status($id)
    {
        $review = Review::findOrfail($id);
        $review->status == 1 ? $review->status = 0 : $review->status = 1;
        $review->save();
        return redirect()->back();
    }

    public function deleteReview(Request $request)
    {
        $reviews = Review::findOrFail($request->delete_id);
        $reviews->delete();
        session()->flash('success', trans('pages.delete_all_sucessfully'));
        return redirect()->back();
    }
}
