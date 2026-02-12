<?php

namespace App\Http\Controllers\Admin\Charity;

use App\Models\CharityTag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Charity\CharityTagRequest;

class CharityTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = CharityTag::query()->with('trans')->orderBy('id', 'DESC');
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
        return view('admin.dashboard.chairty.tag.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.dashboard.chairty.tag.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CharityTagRequest $request)
    {
        $data = $request->getSanitized();
        if ($request->hasFile('image')) {
            $data['image'] = $this->upload_file($request->file('image'), ('Charity_Tags'), 1);
        }
        if ($request->hasFile('background_image')) {
            $data['background_image'] = $this->upload_file($request->file('background_image'), ('Charity_Tags'), 2);
        }
        CharityTag::create($data);
        session()->flash('success', trans('message.admin.created_sucessfully'));
        if(request()->submit == "new"){ return  redirect()->back();}
        return redirect()->route('admin.charity.tag.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tag = CharityTag::query()->with('trans')->findOrFail($id);
        return view('admin.dashboard.chairty.tag.show', compact('tag'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tag = CharityTag::query()->with('trans')->findOrFail($id);
        return view('admin.dashboard.chairty.tag.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CharityTagRequest $request, $id)
    {
        $tag = CharityTag::query()->with('trans')->findOrFail($id);
        $data = $request->getSanitized();
        if ($request->hasFile('image')) {
            $this->delete_file($tag->image);
            $data['image'] = $this->upload_file($request->file('image'), ('Charity_Tags'), 1);
        }
        if ($request->hasFile('background_image')) {
            $this->delete_file($tag->background_image);
            $data['background_image'] = $this->upload_file($request->file('background_image'), ('Charity_Tags'), 2);
        }
        $tag->update($data);
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        if (request()->submit == "update") {  return  redirect()->back(); }
        return redirect()->route('admin.charity.tag.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $tag = CharityTag::query()->with('trans')->findOrFail($id);
        $this->delete_file($tag->image);
        $tag->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }


    //Method Update status
    public function update_status($id)
    {
        $tag = CharityTag::findOrfail($id);
        $tag->status == 1 ? $tag->status = 0 : $tag->status = 1;
        $tag->save();
        return redirect()->back();
    }
    // Method Update Featured
    public function update_featured($id)
    {
        $tag = CharityTag::findOrfail($id);
        $tag->feature == 1 ? $tag->feature = 0 : $tag->feature = 1;
        $tag->save();
        return redirect()->back();
    }

    // Method Update All Status And delete All
    // Delete All

    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $tags = CharityTag::findMany($request['record']);
            foreach ($tags as $tag) {
                $tag->update(['status' => 1]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $tags = CharityTag::findMany($request['record']);
            foreach ($tags as $tag) {
                $tag->update(['status' => 0]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $tags = CharityTag::findMany($request['record']);
            foreach ($tags as $tag) {
                $this->delete_file($tag->image);
                $this->delete_file($tag->background_image);
                $tag->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }
}
