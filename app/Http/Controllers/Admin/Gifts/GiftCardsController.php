<?php

namespace App\Http\Controllers\Admin\Gifts;

use App\Models\GiftCards;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Gifts\GiftCardsRequest;
use App\Models\GiftCategories;
use App\Models\GiftOccasioins;

class GiftCardsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('livewire.admin.gifts.cards.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = GiftCategories::with('trans')->get();
        $occasioins = GiftOccasioins::with('trans')->get();
        return view('admin.dashboard.gifts.cards.create', compact('categories', 'occasioins'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GiftCardsRequest $request)
    {
        $data = $request->getSanitized();
        if ($request->hasFile('image')) {
            $data['image'] = $this->upload_file($request->file('image'), ('gift_cards'), 1);
        }
        $card = GiftCards::create($data);
        $card->occasioins()->attach($data['occasioins']);
        session()->flash('success', trans('message.admin.created_sucessfully'));
        if(request()->submit == "new"){ return  redirect()->back();}
        return redirect()->route('admin.gifts.cards.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = GiftCards::query()->with('category', 'occasioins')->findOrFail($id);
        return view('admin.dashboard.gifts.cards.show',compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {        
        $item = GiftCards::query()->with('category', 'occasioins')->findOrFail($id);
        $categories = GiftCategories::with('trans')->get();
        $occasioins = GiftOccasioins::with('trans')->get();
        return view('admin.dashboard.gifts.cards.edit',compact('item', 'categories', 'occasioins'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GiftCardsRequest $request, string $id)
    {
        $card = GiftCards::query()->with('category', 'occasioins')->findOrFail($id);
        $data = $request->getSanitized();
        if ($request->hasFile('image')) {
            $this->delete_file($card->image);
            $data['image'] = $this->upload_file($request->file('image'), ('gift_cards'), 1);
        }
        $card->update($data);
        $card->occasioins()->sync(@$data['occasioins']);
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        if (request()->submit == "update") {  return  redirect()->back(); }
        return redirect()->route('admin.gifts.cards.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GiftCards $giftCard)
    {
        $this->delete_file($giftCard->image);
        $giftCard->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }

    public function update_status($id)
    {
        $item = GiftCards::findOrfail($id);
        $item->status == 1 ? $item->status = 0 : $item->status = 1;
        $item->save();
        return redirect()->back();
    }




    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $items = GiftCards::findMany($request['record']);
            foreach ($items as $item) {
                $item->update(['status' => 1]);
            }
            session()->flash('success', trans('categories.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $items = GiftCards::findMany($request['record']);
            foreach ($items as $item) {
                $item->update(['status' => 0]);
            }
            session()->flash('success', trans('categories.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $items = GiftCards::findMany($request['record']);
            foreach ($items as $item) {
                $this->delete_file($item->image);
                $item->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }


  
}
