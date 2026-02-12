<?php

namespace App\Http\Controllers\Admin\Gifts;

use Illuminate\Http\Request;
use App\Models\GiftCategories;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Gifts\GiftCategoryRequest;

class GiftCategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('livewire.admin.gifts.categories.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $query = GiftCategories::query()->with('trans');
        $ids = arrang_records(clone $query);
        if($ids)$categories = @$query->whereIn('id', $ids)->orderByRaw("field(id,".implode(',',$ids).")")->get();
        else $categories = $query->get();
        return view('admin.dashboard.gifts.categories.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GiftCategoryRequest $request)
    {
        $data = $request->getSanitized();
        GiftCategories::create($data);
        session()->flash('success', trans('message.admin.created_sucessfully'));
        if(request()->submit == "new"){ return  redirect()->back();}
        return redirect()->route('admin.gifts.categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = GiftCategories::query()->with('trans')->findOrFail($id);
        $query = GiftCategories::query()->with('trans');
        $childs =  get_childs_id($item->children,  $query);
        $ids = arrang_records(clone $query);
        if($ids)$categories = $query->whereIn('id', $ids)->whereNotIn('id', $childs)->where('id','!=',  $item->id)->orderByRaw("field(id,".implode(',',$ids).")")->get();
        else $categories = $query->get();
    
        return view('admin.dashboard.gifts.categories.show',compact('categories','item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {        
        $item = GiftCategories::query()->with('trans')->findOrFail($id);
        $query = GiftCategories::query()->with('trans');
        $childs =  get_childs_id($item->children,  $query);
        $ids = arrang_records(clone $query);
        if($ids)$categories = $query->whereIn('id', $ids)->whereNotIn('id', $childs)->where('id','!=',  $item->id)->orderByRaw("field(id,".implode(',',$ids).")")->get();
        else $categories = $query->get();
        return view('admin.dashboard.gifts.categories.edit',compact('categories','item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GiftCategoryRequest $request, string $id)
    {
        $category = GiftCategories::query()->with('trans')->findOrFail($id);
        $data = $request->getSanitized();
        $category->update($data);
        $items = GiftCategories::query()->with('trans')->get();
        update_childs_level($category, $items);
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        if (request()->submit == "update") {  return  redirect()->back(); }
        return redirect()->route('admin.gifts.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = GiftCategories::with(['children', 'trans'])->findOrFail($id);
        
        // Delete all children categories first
        if ($category->children->isNotEmpty()) {
            foreach ($category->children as $child) {
                $child->delete();
            }
        }
        
        // Delete translations
        $category->trans()->delete();
        
        // Delete the category itself
        $category->delete();
        
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }

    public function update_status($id)
    {
        $item = GiftCategories::findOrfail($id);
        $item->status == 1 ? $item->status = 0 : $item->status = 1;
        $item->save();
        return redirect()->back();
    }




    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $items = GiftCategories::findMany($request['record']);
            foreach ($items as $item) {
                $item->update(['status' => 1]);
            }
            session()->flash('success', trans('categories.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $items = GiftCategories::findMany($request['record']);
            foreach ($items as $item) {
                $item->update(['status' => 0]);
            }
            session()->flash('success', trans('categories.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $items = GiftCategories::findMany($request['record']);
            foreach ($items as $item) {
                $this->delete_file($item->image);
                $item->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }


    public function show_tree(Request $request)
    {
        $items =  GiftCategories::query()->with('trans')->get();
        $searchItem = [];
        if($request->title){
            $searchItem = GiftCategories::query()->with('trans')->orWhereTranslationLike('title', '%' . $request->title . '%')->get();  
        }
        return view('admin.dashboard.gifts.categories.index',compact('items', 'searchItem'));   
    }
}
