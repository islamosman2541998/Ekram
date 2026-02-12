<?php

namespace App\Http\Controllers\Admin\Products;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\ProductCategoryRequest;

class ProductCategoryControler extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dashboard.products.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $query = ProductCategory::query()->with('trans');
        $ids = arrang_records(clone $query);
        if ($ids) $categories = @$query->whereIn('id', $ids)->orderByRaw("field(id," . implode(',', $ids) . ")")->get();
        else $categories = $query->get();

        return view('admin.dashboard.products.category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCategoryRequest $request)
    {

        $data = $request->getSanitized();

        if ($request->hasFile('image')) {
            $data['image'] = $this->upload_file($request->file('image'), ('charity_category'));
        }
        if ($request->hasFile('bcakground_image')) {
            $data['bcakground_image'] = $this->upload_file($request->file('bcakground_image'), ('charity_category'));
        }
        ProductCategory::create($data);
        session()->flash('success', trans('message.admin.created_sucessfully'));
        if(request()->submit == "new"){ return  redirect()->back();}
        return redirect()->route('admin.eccommerce.categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = ProductCategory::query()->with('trans')->findOrFail($id);
        $query = ProductCategory::query()->with('trans');
        $childs =  get_childs_id($item->children,  $query);
        $ids = arrang_records(clone $query);
        if ($ids) $categories = $query->whereIn('id', $ids)->whereNotIn('id', $childs)->where('id', '!=',  $item->id)->orderByRaw("field(id," . implode(',', $ids) . ")")->get();
        else $categories = $query->get();

        return view('admin.dashboard.products.category.show', compact('categories', 'item'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = ProductCategory::query()->with('trans')->findOrFail($id);
        $query = ProductCategory::query()->with('trans');
        $childs =  get_childs_id($item->children,  $query);
        $ids = arrang_records(clone $query);

        if ($ids) $categories = $query->whereIn('id', $ids)->whereNotIn('id', $childs)->where('id', '!=',  $item->id)->orderByRaw("field(id," . implode(',', $ids) . ")")->get();
        else $categories = $query->get();
        return view('admin.dashboard.products.category.edit', compact('categories', 'item'));

       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(ProductCategoryRequest $request, $id)
    {
        $category = ProductCategory::query()->with('trans')->findOrFail($id);
        $data = $request->getSanitized();
        if ($request->hasFile('image')) {
            $this->delete_file($category->image);
            $data['image'] = $this->upload_file($request->file('image'), ('charity_category'));
        }
        if ($request->hasFile('background_image')) {
            $this->delete_file($category->background_image);
            $data['background_image'] = $this->upload_file($request->file('background_image'), ('charity_category'));
        }
        $category->update($data);
        $items = ProductCategory::query()->with('trans')->get();
        update_childs_level($category, $items);
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        if (request()->submit == "update") {  return  redirect()->back(); }
        return redirect()->route('admin.eccommerce.categories.index');    }

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
