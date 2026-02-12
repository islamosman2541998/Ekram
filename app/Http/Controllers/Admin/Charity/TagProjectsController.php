<?php

namespace App\Http\Controllers\Admin\Charity;

use App\Models\TagProjects;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Charity\TagProjectRequest;

class TagProjectsController extends Controller
{
    public function index(Request $request){
        $query = TagProjects::query()->with('trans')->orderBy('id','DESC');
        if($request->status  != ''){
            $query->where('status', $request->status );
        }
        if($request->title  != ''){
            $query->orWhereTranslationLike('title','%'.$request->title.'%');
        }
        if($request->description != ''){
            $query->orWhereTranslationLike('description','%'.$request->title.'%');

        }
        $items = $query->paginate($this->pagination_count);
        return view('admin.dashboard.projectTags.index',compact('items'));
    }


    public function create(){
        return view('admin.dashboard.projectTags.create');
    }


    public function store(TagProjectRequest $request){
        $data = $request->getSanitized();
        if($request->hasFile('image')){
            $data['image'] = $this->upload_file($request->file('image') , ('ProjectTags'));
        }
        if($request->hasFile('background_image')){
            $data['background_image'] = $this->upload_file($request->file('background_image') , ('ProjectTags'));
        }
        TagProjects::create($data);
        session()->flash('success' , trans('message.admin.created_sucessfully') );
        if(request()->submit == "new"){ return  redirect()->back();}
        return redirect()->route('admin.project-tags.index');
    }

    public function show(TagProjects $project_tag){
        return view('admin.dashboard.projectTags.show',compact('project_tag'));   

    }


    public function edit(TagProjects $project_tag){

        return view('admin.dashboard.projectTags.edit',compact('project_tag'));   
    }


    public function update(TagProjectRequest $request, TagProjects $project_tag){
        $data = $request->getSanitized();
        if($request->hasFile('image')){
            $this->delete_file($project_tag->image);
            $data['image'] = $this->upload_file($request->file('image') , ('ProjectTags'));
        }
        if($request->hasFile('background_image')){
            $this->delete_file($project_tag->background_image);
            $data['background_image'] = $this->upload_file($request->file('background_image') , ('ProjectTags'));
        }
        $project_tag->update($data);

         session()->flash('success' , trans('message.admin.updated_sucessfully') );
         if(request()->submit == "update"){ return  redirect()->back();}
         return  redirect()->route('admin.project-tags.index');
    }


    public function destroy(TagProjects $project_tag){
        $this->delete_file($project_tag->image);
        $this->delete_file($project_tag->background_image);
        $project_tag->delete();
        session()->flash('success' , trans('message.admin.deleted_sucessfully') );
        return redirect()->back();
    }


    //Method Update status
    public function update_status($id){
        $tag = TagProjects::findOrfail($id);
        $tag->status == 1 ? $tag->status = 0 : $tag->status = 1;
        $tag->save();
        return redirect()->back();
    }
    // Method Update Featured
    public function update_featured($id){
        $tag = TagProjects::findOrfail($id);
        $tag->feature == 1 ? $tag->feature = 0 : $tag->feature = 1;
        $tag->save();
        return redirect()->back();
    }

    // Method Update All Status And delete All
        // Delete All 

        public function actions(Request $request){
            if($request['publish'] == 1 ){
                $tags = TagProjects::findMany($request['record']);
                foreach ($tags as $tag){
                    $tag->update(['status' => 1]);
                }
                session()->flash('success' , trans('articles.status_changed_sucessfully') );
            }
            if($request['unpublish'] == 1 ){
                $tags = TagProjects::findMany($request['record']);
                foreach ($tags as $tag){
                    $tag->update(['status' => 0]);
                }
                session()->flash('success' , trans('articles.status_changed_sucessfully') );
            }
            if($request['delete_all'] == 1 ){
                $tags = TagProjects::findMany($request['record']);
                foreach ($tags as $tag){
                    $this->delete_file($tag->image);
                    $this->delete_file($tag->background_image);
                    $tag->delete();
                }
                session()->flash('success' , trans('pages.delete_all_sucessfully') );
            }
            return redirect()->back();
        }
}
