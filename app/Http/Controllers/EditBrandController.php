<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class EditBrandController extends Controller
{
    public function edit($id)
    {
        $Brand = Brand::findOrFail($id);

        return view('admin.Brands.EditBrand ', compact('Brand'));
    }

   /* public function update(Request $req,$id)
    {
        $Brand = Brand::findOrFail($id);

        $Brand->name = $req->name;
        $Brand->status = $req->status;

        if($req->file('image'))
        {
            $file = $req->file('image');
            $filename = time().".".$file->extension();
            $file->move(public_path('products'),$filename);

            $Brand->image = $filename;
        }

        $Brand->save();

        return redirect('/brand')->with('success','Category Updated Successfully');
    }*/

    public function update(Request $req, $id)
    {
        $Brand = Brand::findOrFail($id);

        // ✅ Validation
        $req->validate([
            'name'   => 'required|string|max:255|unique:brands,name,' . $id,
            'status' => 'required|in:0,1',
            'image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ], [
            'name.required' => 'Please enter brand name',
            'name.unique'   => 'Brand already exists',

            'image.image'   => 'File must be an image',
            'image.mimes'   => 'Only JPG, PNG, WEBP allowed',
            'image.max'     => 'Image must be less than 2MB',
        ]);

        $Brand->name = $req->name;
        $Brand->status = $req->status;

        // ✅ Image update logic
        if ($req->hasFile('image')) {

            // 🔒 Delete old image
            if (!empty($Brand->image)) {
                $oldPath = public_path('uploads/brands/' . $Brand->image);

                if (file_exists($oldPath) && is_file($oldPath)) {
                    unlink($oldPath);
                }
            }

            // 📤 Upload new image
            $file = $req->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('uploads/brands'), $filename);

            // 💾 Save new image
            $Brand->image = $filename;
        }

        $Brand->save();

        return redirect('/brand')->with('success', 'Brand Updated Successfully');
    }
    public function changeStatus($id)
    {
        $variant = Brand::find($id);

        if($variant->status == 1){
            $variant->status = 0;
        }else{
            $variant->status = 1;
        }

        $variant->save();

        return redirect()->back();
    }
}
