<?php

namespace App\Http\Controllers;


use App\Models\Category;
use Illuminate\Http\Request;
class EditCatagoryController extends Controller
{
    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('admin.Category.editcatagory', compact('category'));
    }
    public function index()
    {
        $category = Category::all();

        return view('admin.catagory', compact('category'));
    }

    public function update(Request $req,$id)
    {
        $category = Category::findOrFail($id);

        $category->name = $req->name;
        $category->status = $req->status;

        if($req->file('image'))
        {
            $file = $req->file('image');
            $filename = time().".".$file->extension();
            $file->move(public_path('products'),$filename);

            $category->image = $filename;
        }

        $category->save();

        return redirect('/catagory')->with('success','Category Updated Successfully');
    }
    public function changeStatus($id)
    {
        $variant = Category::find($id);

        if($variant->status == 1){
            $variant->status = 0;
        }else{
            $variant->status = 1;
        }

        $variant->save();

        return redirect()->back();
    }
}
