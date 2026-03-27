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

   /* public function update(Request $req,$id)
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
    }*/
    public function update(Request $req, $id)
    {
        $category = Category::findOrFail($id);

        // ✅ Validation
        $req->validate([
            'name'   => 'required|string|max:255|unique:categories,name,' . $id,
            'status' => 'required|in:0,1',
            'image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ], [
            'name.required' => 'Please enter category name',
            'name.unique'   => 'Category already exists',

            'image.image'   => 'File must be an image',
            'image.mimes'   => 'Only JPG, PNG, WEBP allowed',
            'image.max'     => 'Image must be less than 2MB',
        ]);

        // ✅ Update fields
        $category->name = $req->name;
        $category->status = $req->status;

        // ✅ Image update logic
        if ($req->hasFile('image')) {

            // 🔒 Delete old image
            if (!empty($category->image)) {
                $oldPath = public_path('products/' . $category->image);

                if (file_exists($oldPath) && is_file($oldPath)) {
                    unlink($oldPath);
                }
            }

            // 📤 Upload new image
            $file = $req->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('products'), $filename);

            // 💾 Save new image
            $category->image = $filename;
        }

        $category->save();

        return redirect('/catagory')->with('success', 'Category Updated Successfully');
    }
    public function changeStatus($id)
    {
        $category = Category::find($id);

        if($category->status == 1){
            $category->status = 0;
        }else{
            $category->status = 1;
        }

        $category->save();

        return redirect()->back();
    }
}
