<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\VariantsOption;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;

use Illuminate\Support\Facades\Validator;


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
        $brands = \App\Models\Brand::where('status', 1)->get();
        $categories =  \App\Models\Category::where('status', 1)->get();
        $variants = VariantsOption::with('values')->get();

        return view('admin.Product.add-product',compact('brands','categories','variants'),
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'price'        => 'required|numeric|min:1',
            'listed_price' => 'required|numeric|min:1|gte:price',
            'Description'  => 'required|string|max:1000',
            'brands'       => 'required|exists:brands,id',
            'categories'   => 'required|exists:categories,id',
            'image'        => 'required|image|mimes:jpg,jpeg,png,webp|max:2048'
        ], [
            'name.required'         => 'Please enter product name',
            'name.max'              => 'Product name too long',

            'price.required'        => 'Please enter price',
            'price.numeric'         => 'Price must be a number',
            'price.min'             => 'Price must be greater than 0',

            'listed_price.required' => 'Please enter listed price',
            'listed_price.numeric'  => 'Listed price must be a number',
            'listed_price.gte'      => 'Listed price must be greater than or equal to price',

            'Description.required'  => 'Please enter description',

            'brands.required'       => 'Please select brand',
            'brands.exists'         => 'Selected brand is invalid',

            'categories.required'   => 'Please select category',
            'categories.exists'     => 'Selected category is invalid',

            'image.required'        => 'Please upload product image',
            'image.image'           => 'File must be an image',
            'image.mimes'           => 'Only JPG, PNG, WEBP allowed',
            'image.max'             => 'Image size must be less than 2MB',
        ]);

        if ($request->fails()) {
            return back()->withErrors($request)->withInput(); // ✅ HERE
        }

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
        $req->validate([
            'name'         => 'required|string|max:255',
            'price'        => 'required|numeric|min:1',
            'listed_price' => 'required|numeric|min:1|gte:price',
            'Description'  => 'required|string|max:1000',
            'brands'       => 'required|exists:brands,id',
            'categories'   => 'required|exists:categories,id',
            'image'        => 'required|image|mimes:jpg,jpeg,png,webp|max:2048'
        ], [
            'name.required'         => 'Please enter product name',
            'name.max'              => 'Product name too long',

            'price.required'        => 'Please enter price',
            'price.numeric'         => 'Price must be a number',
            'price.min'             => 'Price must be greater than 0',

            'listed_price.required' => 'Please enter listed price',
            'listed_price.numeric'  => 'Listed price must be a number',
            'listed_price.gte'      => 'Listed price must be greater than or equal to price',

            'Description.required'  => 'Please enter description',

            'brands.required'       => 'Please select brand',
            'brands.exists'         => 'Selected brand is invalid',

            'categories.required'   => 'Please select category',
            'categories.exists'     => 'Selected category is invalid',

            'image.required'        => 'Please upload product image',
            'image.image'           => 'File must be an image',
            'image.mimes'           => 'Only JPG, PNG, WEBP allowed',
            'image.max'             => 'Image size must be less than 2MB',
        ]);




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
        // ✅ Validation
        $request->validate([
            'name'   => 'required|string|max:255|unique:brands,name',
            'status' => 'nullable|boolean',
            'image'  => 'required|image|mimes:jpg,jpeg,png,webp|max:2048'
        ], [
            'name.required'  => 'Please enter brand name',
            'name.unique'    => 'Brand already exists',

            'image.required' => 'Please upload brand image',
            'image.image'    => 'File must be an image',
            'image.mimes'    => 'Only JPG, PNG, WEBP allowed',
            'image.max'      => 'Image must be less than 2MB',
        ]);

        // ✅ Create Brand
        $brand = new Brand();
        $brand->name = $request->name;
        $brand->status = $request->status ? 1 : 0;

        // ✅ Image Upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('uploads/brands'), $imageName);

            $brand->image = $imageName;
        }

        $brand->save();

        return redirect()->route('brand.brandindex')
            ->with('success', 'Brand Created Successfully');
    }
    function deletebrand($id){

        Brand::destroy($id);
        return redirect()->route('brand.brandindex');
    }

}
