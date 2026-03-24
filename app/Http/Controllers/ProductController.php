<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\VariantsOption;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;



class ProductController extends Controller
{
    public function storee(Request $request)
    {
        // Step 1: Save Product
        $product = new Product();

        $product->name = $request->name;   // get form name
        $product->price = $request->price;

        $product->save();

        // Step 2: Save Variants
        if($request->variant_value){

            foreach($request->variant_value as $key => $value){

                ProductVariant::create([
                    'product_id' => $product->id,
                    'value_id' => $value,
                    'stock' => $request->stock[$key],
                    'minStock' => $request->min_stock[$key],
                ]);

            }
        }

        return redirect()->back()->with('success','Product Added Successfully');
    }
    public function index()
    {
        $products = Product::all();


        return view('admin.Product.products',compact('products'));
    }


    public function create()
    {
        $brands = Brand::all();
        $categories = Category::all();
        $variants = VariantsOption::with('values')->get();

        return view('admin.Product.add-product',compact('brands','categories','variants'),
        );
    }

    public function store(Request $request)
    {

        // VALIDATION
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'listed_price' => 'required',
            'Description' => 'required',
            'brands' => 'required',
            'categories' => 'required',
            'image' => 'required|image'
        ],[
            'name.required' => 'Please fill up Product Name',
            'price.required' => 'Please fill up Price',
            'listed_price.required' => 'Please fill up Listed Price',
            'Description.required' => 'Please fill up Description',
            'brands.required' => 'Please select Brand',
            'categories.required' => 'Please select Category',
            'image.required' => 'Please upload Product Image'
        ]);



        $product = new Product();

        $product->name = $request->name;
        $product->price = $request->price;
        $product->listed_price = $request->listed_price;
        $product->description = $request->Description;
        $product->brands = $request->brands;
        $product->categories = $request->categories;

        // image upload
        if($request->hasFile('image')){
            $image = $request->image;
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/products'),$imageName);
            $product->image = $imageName;
        }

        $product->save();


        // Save product variants
        if($request->variant_value){

            foreach($request->variant_value as $key => $value){

                if($value != ""){

                    ProductVariant::create([
                        'product_id' => $product->id,
                        'value_id' => $value,
                        'stock' => $request->stock[$key],
                        'minStock' => $request->min_stock[$key],
                    ]);

                }

            }

        }
        return redirect()->route('products.index');
       // return redirect()->back()->with('success','Product Added Successfully');
    }
    function delete($id){

        Product::destroy($id);
        return redirect()->route('products.index');
    }

    public function update(Request $req, $id)
    {
        $product = Product::find($id);

        $product->name = $req->name;
        $product->price = $req->price;
        $product->description = $req->Description;
        $product->listed_price = $req->listed_price;
        $product->brands = $req->brands;
        $product->categories = $req->categories;

        if ($req->hasFile('image')) {

            if (!empty($product->image) && file_exists(public_path('uploads/products/'.$product->image))) {
                unlink(public_path('uploads/products/'.$product->image));
            }

            $image = $req->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/products'), $imageName);

            // Save new image
            $product->image = $imageName;
        }

        $product->save();

        return redirect()->route('products.index');

    }
    public function edit($id)
    {
        $data = Product::find($id);
        $brands = Brand::all();
        $categories = Category::all();

        return view('admin.Product.editproduct',compact('data','brands','categories'));
    }

    public function createbrand()
    {
        $brands = Brand::all();
        return view('admin.Brands.brandsListing', compact('brands'));
    }

    public function storebrand(Request $request)
    {
        $brand = new Brand();

        $brand->name = $request->name;
        $brand->status = $request->status;

        if($request->hasFile('image')){
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/products'), $imageName);
            $brand->image = $imageName;
        }

        $brand->save();

        return redirect()->route('brand.brandindex');
    }
    function deletebrand($id){

        Brand::destroy($id);
        return redirect()->route('brand.brandindex');
    }

}
