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

    public function update(Request $req,$id)
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
