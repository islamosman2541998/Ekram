<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryProjectsController extends Controller
{
  
    public function index()
    {
        return view('livewire.admin.categories.index');
    }


    public function create()
    {
        $editMode = false;
        return view('livewire.admin.categories.form', compact('editMode'));
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        $showMode = true;
        $categoryID = $id;
        return view('livewire.admin.categories.form', compact('showMode', 'categoryID'));
    }

 
    public function edit($id)
    {
        $editMode = true;
        $categoryID = $id;
        return view('livewire.admin.categories.form', compact('editMode', 'categoryID'));
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }

    public function textView(){

        return view('admin.testView');
    }
}
