<?php

namespace App\Http\Controllers\Admin\Products;

use App\Models\AttributeSet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\AttributesSetRequest;

class AttributesSetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request  $request)
    {
        $query = AttributeSet::query()->with('trans')->orderBy('id', 'DESC');
        if ($request->status  != '') {
            $query->where('status', $request->status);
        }
        if ($request->title  != '') {
            $query->orWhereTranslationLike('title', '%' . $request->title . '%');
        }

        $items = $query->paginate($this->pagination_count);
        return view('admin.dashboard.products.attributes-set.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.dashboard.products.attributes-set.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttributesSetRequest $request)
    {
        $data = $request->getSanitized();
        AttributeSet::create($data);
        session()->flash('success', trans('message.admin.created_sucessfully'));
        if(request()->submit == "new"){ return  redirect()->back();}
        return redirect()->route('admin.eccommerce.attributes-set.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $items = AttributeSet::findOrFail($id);
        return view('admin.dashboard.products.attributes-set.show', compact('items'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $items = AttributeSet::findOrFail($id);
        return view('admin.dashboard.products.attributes-set.edit', compact('items'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AttributesSetRequest $request, $id)
    {
        $attributes = AttributeSet::query()->with('trans')->findOrFail($id);
        $data = $request->getSanitized();
        $attributes->update($data);
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        if (request()->submit == "update") {  return  redirect()->back(); }
        return redirect()->route('admin.eccommerce.attributes-set.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $items = AttributeSet::findOrFail($id)->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }

    public function update_status($id)
    {
        $attributes = AttributeSet::findOrfail($id);
        $attributes->status == 1 ? $attributes->status = 0 : $attributes->status = 1;
        $attributes->save();
        return redirect()->back();
    }
    public function update_featured($id)
    {
        $attributes = AttributeSet::findOrfail($id);
        $attributes->feature == 1 ? $attributes->feature = 0 : $attributes->feature = 1;
        $attributes->save();
        return redirect()->back();
    }

    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $attributes = AttributeSet::findMany($request['record']);
            foreach ($attributes as $attribute) {
                $attribute->update(['status' => 1]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $attributes = AttributeSet::findMany($request['record']);
            foreach ($attributes as $attribute) {
                $attribute->update(['status' => 0]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $attributes = AttributeSet::findMany($request['record']);
            foreach ($attributes as $attribute) {
                $attribute->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }
}
