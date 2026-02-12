<?php

namespace App\Http\Controllers\Admin\Charity;

use App\Http\Controllers\Controller;
use App\Models\VolunteeringIdeas;
use App\Models\VoluntreerIdeaComments;
use Illuminate\Http\Request;

class VolunteerIdeasController extends Controller
{
    public function index(Request $request){

        $query = VolunteeringIdeas::with('comments', 'loves')->orderBy('id', 'DESC');

        if ($request->name  != '') {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->subject  != '') {
            $query->where('subject', 'like', '%' . $request->subject . '%');
        }
        if ($request->message  != '') {
            $query->where('message', 'like', '%' . $request->message . '%');
        }
        if ($request->status  != '') {
            $query->where('status', $request->status);
        }
        if ($request->search_created_from  != '') {
            $query = $query->whereDate('created_at', '>=', $request->search_created_from);
        }
        if ($request->search_created__to  != '') {
            $query = $query->whereDate('created_at', '<=', $request->search_created__to);
        }

        $items = $query->paginate($this->pagination_count);

        return view('admin.dashboard.chairty.volunteers.ideas.index', compact('items'));
    }

    public function show($id)
    {
        $idea = VolunteeringIdeas::with('comments', 'loves')->findOrfail($id);
        return view('admin.dashboard.chairty.volunteers.ideas.show', compact('idea'));
    }


    public function destroy($id)
    {
        $volunteer = VolunteeringIdeas::findOrfail($id);
        $volunteer->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }

    public function deleteComment($id)
    {
        $volunteer = VoluntreerIdeaComments::findOrfail($id);
        $volunteer->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }



    public function update_status($id)
    {
        $volunteer = VolunteeringIdeas::findOrfail($id);
        $volunteer->status == 1 ? $volunteer->status = 0 : $volunteer->status = 1;
        $volunteer->save();
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->back();
    }

    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $volunteers = VolunteeringIdeas::findMany($request['record']);
            foreach ($volunteers as $volunteer) {
                $volunteer->update(['status' => 1]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $volunteers = VolunteeringIdeas::findMany($request['record']);
            foreach ($volunteers as $volunteer) {
                $volunteer->update(['status' => 0]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $volunteers = VolunteeringIdeas::findMany($request['record']);
            foreach ($volunteers as $volunteer) {
                $volunteer->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }
}
