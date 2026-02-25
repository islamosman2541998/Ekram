<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Models\About;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CMS\AboutRequest;

class AboutController extends Controller
{
   public function index()
{
    $about = About::with('translations')->first();
    return view('admin.dashboard.cms.about.index', compact('about'));
}

    public function update(AboutRequest $request)
    {
        $data = $request->getSanitized();
        $about = About::first();

        if (!$about) {
            // أول مرة - إنشاء
            if ($request->hasFile('image')) {
                $data['image'] = $this->upload_file($request->file('image'), 'about');
            }
            if ($request->hasFile('mission_image')) {
                $data['mission_image'] = $this->upload_file($request->file('mission_image'), 'about');
            }
            if ($request->hasFile('vision_image')) {
                $data['vision_image'] = $this->upload_file($request->file('vision_image'), 'about');
            }
            if ($request->hasFile('values_image')) {
                $data['values_image'] = $this->upload_file($request->file('values_image'), 'about');
            }

            About::create($data);
        } else {
            // تعديل
            if ($request->hasFile('image')) {
                $this->delete_file($about->image);
                $data['image'] = $this->upload_file($request->file('image'), 'about');
            }
            if ($request->hasFile('mission_image')) {
                $this->delete_file($about->mission_image);
                $data['mission_image'] = $this->upload_file($request->file('mission_image'), 'about');
            }
            if ($request->hasFile('vision_image')) {
                $this->delete_file($about->vision_image);
                $data['vision_image'] = $this->upload_file($request->file('vision_image'), 'about');
            }
            if ($request->hasFile('values_image')) {
                $this->delete_file($about->values_image);
                $data['values_image'] = $this->upload_file($request->file('values_image'), 'about');
            }

            $about->update($data);
        }

        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->back();
    }
}