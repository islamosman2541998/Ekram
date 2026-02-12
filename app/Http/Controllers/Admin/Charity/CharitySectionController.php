<?php

namespace App\Http\Controllers\Admin\Charity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Charity\CharitySectionRequest;
use App\Models\CategoryProjects;
use App\Models\CharitySection;
use Illuminate\Http\Request;

class CharitySectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.dashboard.chairty.section.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $query = CategoryProjects::query()->with('trans');
        $ids = arrang_records(clone $query->get());
        if($ids)$categories = @$query->whereIn('id', $ids)->orderByRaw("field(id,".implode(',',$ids).")")->get();
        else $categories = $query->get();
        return view('admin.dashboard.chairty.section.create',compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CharitySectionRequest $request)
    {
        $data = $request->getSanitized();

        if ($request->hasFile('image')) {
            $data['image'] = $this->upload_file($request->file('image'), ('charity_section'), 1);
        }
        if ($request->hasFile('background_image')) {
            $data['background_image'] = $this->upload_file($request->file('background_image'), ('charity_section'), 2);
        }
        $section = CharitySection::create($data);
        $section->categories()->attach($data['categories']);
        session()->flash('success', trans('message.admin.created_sucessfully'));
        if(request()->submit == "new"){ return  redirect()->back();}

        return redirect()->route('admin.charity.sections.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = CharitySection::query()->with('trans')->findOrFail($id);

        $query = CategoryProjects::query()->with('trans');
        $ids = arrang_records(clone $query);
        if($ids)$categories = $query->whereIn('id', $ids)->orderByRaw("field(id,".implode(',',$ids).")")->get();
        else $categories = $query->get();
    
        return view('admin.dashboard.chairty.section.show',compact('categories','item'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = CharitySection::query()->with('trans')->findOrFail($id);

        $query = CategoryProjects::query()->with('trans');
        $ids = arrang_records(clone $query->get());
        if($ids)$categories = $query->whereIn('id', $ids)->orderByRaw("field(id,".implode(',',$ids).")")->get();
        else $categories = $query->get();
    
        return view('admin.dashboard.chairty.section.edit',compact('categories','item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CharitySectionRequest $request, $id)
    {
        $section = CharitySection::query()->with('trans')->findOrFail($id);
        $data = $request->getSanitized();
        if ($request->hasFile('image')) {
            $this->delete_file($section->image);
            $data['image'] = $this->upload_file($request->file('image'), ('charity_section'), 1);
        }
        if ($request->hasFile('background_image')) {
            $this->delete_file($section->background_image);
            $data['background_image'] = $this->upload_file($request->file('background_image'), ('charity_section'), 2);
        }
        $section->update($data);
        $section->categories()->sync($data['categories']);
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        if (request()->submit == "update") {  return  redirect()->back(); }

        return redirect()->route('admin.charity.sections.index');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $section = CharitySection::query()->with('trans')->findOrFail($id);
        $this->delete_file($section->image);
        $section->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }
}
