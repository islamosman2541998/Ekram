<?php

namespace App\Http\Controllers\Admin\Products;

use App\Models\Attribute;
use App\Models\AttributeSet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\AttributesValueRequest;

class AttributesController extends Controller
{

    public function index(Request  $request, $id)
    {

        // dd($request->all());
        $attributeset_id = $id;
        $query =  Attribute::query()->with('attributeSet', 'trans')->orderBy('id', 'DESC');
        if ($request->status  != '') {
            $query->where('status', $request->status);
        }
        if ($request->title  != '') {
            $query->orWhereTranslationLike('title', '%' . $request->title . '%');
        }
        $attributes = $query->where('attribute_set_id', $id)->paginate($this->pagination_count);


        return view('admin.dashboard.products.attributes.index', compact('attributes', 'attributeset_id'));
    }
    public function add($id)
    {

        $attributes = AttributeSet::findOrFail($id);

        return view('admin.dashboard.products.attributes.create', compact('attributes'));
    }
    // store to Attributes Tabel

    public function store(AttributesValueRequest $request)
    {
        $data = $request->getSanitized();
        if ($request->hasFile('image')) {
            $data['image'] = $this->upload_file($request->file('image'), ('attributes'));
        }
        Attribute::create($data);
        session()->flash('success', trans('message.admin.created_sucessfully'));
        if (request()->submit == "new") {
            return  redirect()->back();
        }
        return redirect()->route('admin.eccommerce.attributes.index');
    }

    // Method Edit attributes

    public function edit($id)
    {

        $attributes = Attribute::with('attributeSet', 'trans')->findOrFail($id);
        // dd($attributes);
        return view('admin.dashboard.products.attributes.edit', compact('attributes'));
    }


    // Method update Attributes

    public function update(AttributesValueRequest $request)
    {

        $attributes = Attribute::findOrFail($request->id);

        $data = $request->getSanitized();
        if ($request->hasFile('image')) {
            $this->delete_file($attributes->image);
            $data['image'] = $this->upload_file($request->file('image'), ('attributes'));
        }
        $attributes->update($data);
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        if (request()->submit == "update") {
            return  redirect()->back();
        }
        if (request()->submit == "update") {  return  redirect()->back(); }
        return redirect()->route('admin.eccommerce.attributes.index');
    }


    //Method Update status
    public function update_status($id)
    {
        $attribute = Attribute::findOrfail($id);
        $attribute->status == 1 ? $attribute->status = 0 : $attribute->status = 1;
        $attribute->save();
        return redirect()->back();
    }
    // Method Update All Status And delete All
    // Delete All

    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $attributes = Attribute::findMany($request['record']);
            foreach ($attributes as $attribute) {
                $attribute->update(['status' => 1]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $attributes = Attribute::findMany($request['record']);
            foreach ($attributes as $attribute) {
                $attribute->update(['status' => 0]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $attributes = Attribute::findMany($request['record']);
            foreach ($attributes as $attribute) {
                $this->delete_file($attribute->image);
                $attribute->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }


    // Delete Attribute

    public function destroy($id)
    {


        $attributes = Attribute::findOrFail($id);
        $this->delete_file($attributes->image);
        $attributes->delete();
        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->back();
    }
}
