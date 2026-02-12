<?php

namespace App\Http\Controllers\Admin\Charity;

use Illuminate\Http\Request;
use App\Models\CategoryProjects;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Charity\CharityCategoryRequest;

class CharityCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dashboard.chairty.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $query = CategoryProjects::query()->with('trans');
        $ids = arrang_records(clone $query);
        if($ids)$categories = @$query->whereIn('id', $ids)->orderByRaw("field(id,".implode(',',$ids).")")->get();
        else $categories = $query->get();
        return view('admin.dashboard.chairty.category.create',compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CharityCategoryRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->getSanitized();

            if ($request->hasFile('image')) {
                $data['image'] = $this->upload_file($request->file('image'), ('charity_category'), 1);
            }
            if ($request->hasFile('background_image')) {
                $data['background_image'] = $this->upload_file($request->file('background_image'), ('charity_category'), 2);
            }
            
            // Handle cashier_system checkbox
            $data['cashier_system'] = $request->has('cashier_system') ? 1 : 0;
            
            $category = CategoryProjects::create($data);
            
            $this->saveModelTranslation($category, $data); // save or update data

            session()->flash('success', trans('message.admin.created_sucessfully'));

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
        if(request()->submit == "new"){ return  redirect()->back(); }
        return redirect()->route('admin.charity.categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = CategoryProjects::query()->with('trans')->findOrFail($id);
        $query = CategoryProjects::query()->with('trans');
        $childs =  get_childs_id($item->children,  $query);
        $ids = arrang_records(clone $query);
        if($ids)$categories = $query->whereIn('id', $ids)->whereNotIn('id', $childs)->where('id','!=',  $item->id)->orderByRaw("field(id,".implode(',',$ids).")")->get();
        else $categories = $query->get();
    
        return view('admin.dashboard.chairty.category.show',compact('categories','item'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = CategoryProjects::query()->with('trans')->findOrFail($id);
        $query = CategoryProjects::query()->with('trans');
        $childs =  get_childs_id($item->children,  $query);
        $ids = arrang_records(clone $query);
        if($ids)$categories = $query->whereIn('id', $ids)->whereNotIn('id', $childs)->where('id','!=',  $item->id)->orderByRaw("field(id,".implode(',',$ids).")")->get();
        else $categories = $query->get();
    
        return view('admin.dashboard.chairty.category.edit',compact('categories','item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CharityCategoryRequest $request, $id)
    {
        $category = CategoryProjects::query()->with('trans')->findOrFail($id);
        $data = $request->getSanitized();
        if ($request->hasFile('image')) {
            $this->delete_file($category->image);
            $data['image'] = $this->upload_file($request->file('image'), ('charity_category'), 1);
        }
        if ($request->hasFile('background_image')) {
            $this->delete_file($category->background_image);
            $data['background_image'] = $this->upload_file($request->file('background_image'), ('charity_category'), 2);
        }
        
        // Handle cashier_system checkbox
        // $data['cashier_system'] = $request->has('cashier_system') ? 1 : 0;
        
        $category->update($data);
        $this->saveModelTranslation($category, $data); // save or update data
        
        $items = CategoryProjects::query()->with('trans')->get();
        update_childs_level($category, $items);
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        if (request()->submit == "update") {  return  redirect()->back(); }
        return redirect()->route('admin.charity.categories.index');
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
}
