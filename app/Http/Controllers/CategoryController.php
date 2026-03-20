<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function createcatagory()
    {
        $category = Category::all();


        return view('admin.Category.Catagory', compact('category'));
    }

    public function storecatagory(Request $request)
    {
        $catagory = new Category();
        $catagory->name = $request->name;
        /*$catagory->status = $request->status;*/
        $catagory->status = $request->status ? 1 : 0;

        if($request->hasFile('image')){
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('products'), $imageName);
            $catagory->image = $imageName;
        }

        $catagory->save();

        return redirect()->route('catagory.catagoryindex');
    }
    function deletecatagory($id){

        Category::destroy($id);
        return redirect()->route('catagory.catagoryindex');
    }
}
