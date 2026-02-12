<?php

namespace App\Http\Controllers\Admin\Charity;

use Illuminate\Http\Request;
use App\Models\VolunteerPages;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Charity\VolunteerPagesRequest;

class VolunteerPagesController extends Controller
{
    public function index()
    {
        $query = VolunteerPages::query()->with('trans')->orderBy('id','DESC');
        if(request()->input('title')  != ''){
            $query = $query->WhereTranslationLike('title', '%' . request()->input('title') . '%');
        }
        $items = $query->paginate($this->pagination_count);

        return view('admin.dashboard.charity.volunteerpages.index', compact('items'));
    }

    public function create()
    {
        return view('admin.dashboard.charity.volunteerpages.create');
    }


    public function store(VolunteerPagesRequest $request)
    {
        $data =$request->getSanitized();
        if($request->hasFile('image')){
            $data['image'] = $this->upload_file($request->file('image') , ('volunteerPages'));
        }
        VolunteerPages::create($data);
        session()->flash('success' , trans('message.admin.created_sucessfully') );
        if(request()->submit == "new"){ return  redirect()->back();}
        return redirect()->route('admin.volunteerpages.index');
    }


    public function show(VolunteerPages $volunteerpage)
    {
        return view('admin.dashboard.volunteerpages.show' , compact('volunteerpage'));
    }


    public function edit(VolunteerPages $volunteerpage)
    {
        return view('admin.dashboard.volunteerpages.edit' , compact('volunteerpage'));
    }


    public function update(VolunteerPagesRequest $request, VolunteerPages $volunteerpage)
    {
        $data =$request->getSanitized();
        if ($request->hasFile('image')) {
            $this->delete_file($volunteerpage->image);
            $data['image'] = $this->upload_file($request->file('image'), ('volunteerpages'));
        }
        $volunteerpage->update($data);
        session()->flash('success' , trans('message.admin.updated_sucessfully') );
        if(request()->submit == "update"){ return  redirect()->back();}
        return  redirect()->route('admin.volunteerpages.index');
    }

    public function destroy(VolunteerPages $volunteerpage)
    {
        $this->delete_file($volunteerpage->image);
        $volunteerpage->delete();
        session()->flash('success' , trans('message.admin.deleted_sucessfully') );
        return redirect()->back();
    }


    public function update_status($id){
        $volunteerpage = VolunteerPages::findOrfail($id);
        $volunteerpage->status == 1 ? $volunteerpage->status = 0 : $volunteerpage->status = 1;
        $volunteerpage->save();
        return redirect()->back();
    }

    public function actions(Request $request){
        if($request['publish'] == 1 ){
            $volunteerPages = VolunteerPages::findMany($request['record']);
            foreach ($volunteerPages as $volunteerpage){
                $volunteerpage->update(['status' => 1]);
            }
            session()->flash('success' , trans('volunteerpages.status_changed_sucessfully') );
        }
        if($request['unpublish'] == 1 ){
            $volunteerPages = VolunteerPages::findMany($request['record']);
            foreach ($volunteerPages as $volunteerpage){
                $volunteerpage->update(['status' => 0]);
            }
            session()->flash('success' , trans('volunteerpages.status_changed_sucessfully') );
        }
        if($request['delete_all'] == 1 ){
            $volunteerPages = VolunteerPages::findMany($request['record']);
            foreach ($volunteerPages as $volunteerpage){
                $this->delete_file($volunteerpage->image);
                $volunteerpage->delete();
            }
            session()->flash('success' , trans('volunteerpages.delete_all_sucessfully') );
        }
        return redirect()->back();
    }

}
