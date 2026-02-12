<?php

namespace App\Http\Controllers\Admin\Gifts;

use Illuminate\Http\Request;
use App\Models\GiftOccasioins;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Gifts\GiftOccasionsRequest;

class GiftOccasionsController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('livewire.admin.gifts.occasions.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      
        return view('admin.dashboard.gifts.occasions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GiftOccasionsRequest $request)
    {
        $data = $request->getSanitized();
        GiftOccasioins::create($data);
        session()->flash('success', trans('message.admin.created_sucessfully'));
        if(request()->submit == "new"){ return  redirect()->back();}
        return redirect()->route('admin.gifts.occasions.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = GiftOccasioins::query()->with('trans')->findOrFail($id);
        return view('admin.dashboard.gifts.occasions.show',compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {        
        $item = GiftOccasioins::query()->with('trans')->findOrFail($id);
        return view('admin.dashboard.gifts.occasions.edit',compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GiftOccasionsRequest $request, string $id)
    {
        $category = GiftOccasioins::query()->with('trans')->findOrFail($id);
        $data = $request->getSanitized();
        $category->update($data);
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        if (request()->submit == "update") {  return  redirect()->back(); }
        return redirect()->route('admin.gifts.occasions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GiftOccasioins $giftCategories)
    {
        $giftCategories->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }

    public function update_status($id)
    {
        $item = GiftOccasioins::findOrfail($id);
        $item->status == 1 ? $item->status = 0 : $item->status = 1;
        $item->save();
        return redirect()->back();
    }




    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $items = GiftOccasioins::findMany($request['record']);
            foreach ($items as $item) {
                $item->update(['status' => 1]);
            }
            session()->flash('success', trans('categories.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $items = GiftOccasioins::findMany($request['record']);
            foreach ($items as $item) {
                $item->update(['status' => 0]);
            }
            session()->flash('success', trans('categories.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $items = GiftOccasioins::findMany($request['record']);
            foreach ($items as $item) {
                $this->delete_file($item->image);
                $item->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }


}
