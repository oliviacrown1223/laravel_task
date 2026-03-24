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
        // ✅ Validation
        $request->validate([
            'name'   => 'required|string|max:255|unique:categories,name',
            'status' => 'nullable|boolean',
            'image'  => 'required|image|mimes:jpg,jpeg,png,webp|max:2048'
        ], [
            'name.required'  => 'Please enter category name',
            'name.unique'    => 'Category already exists',

            'image.required' => 'Please upload category image',
            'image.image'    => 'File must be an image',
            'image.mimes'    => 'Only JPG, PNG, WEBP allowed',
            'image.max'      => 'Image must be less than 2MB',
        ]);

        // ✅ Create Category
        $catagory = new Category();
        $catagory->name = $request->name;
        $catagory->status = $request->status ? 1 : 0;

        // ✅ Image Upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('products'), $imageName);

            $catagory->image = $imageName;
        }

        $catagory->save();

        return redirect()->route('catagory.catagoryindex')
            ->with('success', 'Category Created Successfully');
    }
    function deletecatagory($id){

        Category::destroy($id);
        return redirect()->route('catagory.catagoryindex');
    }
}
