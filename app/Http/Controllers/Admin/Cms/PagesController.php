<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CMS\PageRequest;
use App\Models\Pages;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PagesController extends Controller
{

    public function index()
    {
        $query = Pages::query()->with('trans')->orderBy('id', 'DESC');
        if (request()->input('title')  != '') {
            $query = $query->WhereTranslationLike('title', '%' . request()->input('title') . '%');
        }
        $items = $query->paginate($this->pagination_count);

        return view('admin.dashboard.cms.pages.index', compact('items'));
    }

    public function create()
    {
        return view('admin.dashboard.cms.pages.create');
    }



    public function store(Request $request)
    {
        $filesArr = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $fileName = $file->getClientOriginalName();
                $file->move(storage_path('app/public/attachments/pages'), $fileName);
                $filesArr[] = 'attachments/pages/' . $fileName;
            }
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $this->upload_file($request->file('image'), 'pages');
        }

        $validated = $request->validate([
            'status' => 'nullable',
        ]);

        // build data
        $data = [];
        foreach (config('translatable.locales') as $locale) {
            $data[$locale] = $request->input($locale, []);
            if (isset($data[$locale]['slug'])) {
                $data[$locale]['slug'] = slug($data[$locale]['slug']);
            }
        }
        $data['status'] = $request->has('status');
        $data['created_by'] = @auth()->user()->id;

        if (!empty($filesArr)) $data['files'] = $filesArr;
        if ($imagePath) $data['image'] = $imagePath;

        Pages::create($data);
        session()->flash('success', trans('message.admin.created_sucessfully'));
        if ($request->submit == "new") return redirect()->back();
        return redirect()->route('admin.pages.index');
    }

    public function update(Request $request, Pages $page)
    {
        $filesArr = null;
        if ($request->hasFile('files')) {
            $existingFiles = $page->files ?? [];
            foreach ($request->file('files') as $file) {
                $fileName = $file->getClientOriginalName();
                $file->move(storage_path('app/public/attachments/pages'), $fileName);
                $existingFiles[] = 'attachments/pages/' . $fileName;
            }
            $filesArr = $existingFiles;
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $this->delete_file($page->image);
            $imagePath = $this->upload_file($request->file('image'), 'pages');
        }

        // build data
        $data = [];
        foreach (config('translatable.locales') as $locale) {
            $data[$locale] = $request->input($locale, []);
            if (isset($data[$locale]['slug'])) {
                $data[$locale]['slug'] = slug($data[$locale]['slug']);
            }
        }
        $data['status'] = $request->has('status');
        $data['updated_by'] = @auth()->user()->id;

        if ($filesArr !== null) $data['files'] = $filesArr;
        if ($imagePath) $data['image'] = $imagePath;

        $page->update($data);
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        if ($request->submit == "update") return redirect()->back();
        return redirect()->route('admin.pages.index');
    }


    public function show(Pages $page)
    {
        return view('admin.dashboard.cms.pages.show', compact('page'));
    }


    public function edit(Pages $page)
    {
        return view('admin.dashboard.cms.pages.edit', compact('page'));
    }



  public function deleteFile(Request $request)
{
    $page = Pages::findOrFail($request->page_id);
    $files = $page->files ?? [];
    $index = (int) $request->file_index;




    if (isset($files[$index])) {
        $filePath = storage_path('app/public/' . $files[$index]);
        if (file_exists($filePath)) {
            @unlink($filePath);
        }
        unset($files[$index]);

        DB::table('pages')
            ->where('id', $request->page_id)
            ->update(['files' => count($files) > 0 ? json_encode(array_values($files)) : null]);
    }

    return redirect()->route('admin.pages.edit', $request->page_id);
}

    public function destroy(Pages $page)
    {
        $this->delete_file($page->image);
        $page->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }


    public function update_status($id)
    {
        $page = Pages::findOrfail($id);
        $page->status == 1 ? $page->status = 0 : $page->status = 1;
        $page->save();
        return redirect()->back();
    }

    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $pages = Pages::findMany($request['record']);
            foreach ($pages as $page) {
                $page->update(['status' => 1]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $pages = Pages::findMany($request['record']);
            foreach ($pages as $page) {
                $page->update(['status' => 0]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $pages = Pages::findMany($request['record']);
            foreach ($pages as $page) {
                $this->delete_file($page->image);
                $page->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }
}
