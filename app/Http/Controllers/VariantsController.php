<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\VariantsOption;
;
use App\Models\VariantsValue;

class VariantsController extends Controller
{
    public function index()
    {
        $variants = VariantsOption::with('values')->get();
        return view('admin.variants.variantListing',compact('variants'));
    }

    public function store(Request $request)
    {
        $variant = VariantsOption::create([
            'name' => $request->name,
            'status' => 1
        ]);

        if($request->values){

            foreach($request->values as $val){

                VariantsValue::create([
                    'option_id' => $variant->id,
                    'value' => $val
                ]);

            }
        }

        return redirect()->route('variants.index');
    }
    function delete($id){

        VariantsOption::destroy($id);
        return redirect()->route('variants.index');
    }
    public function changeStatus($id)
    {
        $variant = VariantsOption::find($id);

        if($variant->status == 1){
            $variant->status = 0;
        }else{
            $variant->status = 1;
        }

        $variant->save();

        return redirect()->back();
    }
    public function edit($id)
    {
        $variants = VariantsOption::findOrFail($id);

        return view('admin.variants.EditVariant ', compact('variants'));
    }

    public function update(Request $request,$id)
    {

        $variant = VariantsOption::find($id);

        $variant->name = $request->name;
        $variant->status = 1;
        $variant->save();

        // delete old values
        VariantsValue::where('option_id',$id)->delete();

        // insert new values
        if($request->values){

            foreach($request->values as $val){

                VariantsValue::create([
                    'option_id' => $id,
                    'value' => $val
                ]);

            }

        }

        return redirect('/variants')->with('success','Variant Updated Successfully');

    }
}
