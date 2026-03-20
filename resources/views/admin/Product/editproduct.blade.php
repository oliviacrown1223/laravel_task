@extends('admin.panel')

@section('content')

    <h3>Edit Product</h3>

    <form action="{{ route('product.update',$data->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">

            <div class="col-md-6">

                <label>Product Name</label>
                <input type="text" name="name" class="form-control mb-3" value="{{$data->name}}">

                <label>Price</label>
                <input type="text" name="price" class="form-control mb-3" value="{{$data->price}}">

            </div>

            <div class="col-md-6">

                <label>Listed Price</label>
                <input type="text" name="listed_price" class="form-control mb-3" value="{{$data->listed_price}}">

                <label>Description</label>
                <textarea name="Description" class="form-control mb-3">{{$data->Description}}</textarea>

               <label>Brands</label>
                <select name="brands" class="form-control mb-3">
                    <option value="">{{$data->brands}}</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->name}}">
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
                <label>categories</label>
                <select name="categories" class="form-control mb-3">
                    <option value="">{{$data->categories}}</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->name}}">
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>

            </div>

            <div class="col-md-6 mt-3">

                <label>Current Image</label><br>
                <img src="/products/{{$data->image}}" width="150" class="mb-3">

            </div>

            <div class="col-md-6 mt-3">

                <label>Change Image</label>
                <input type="file" name="image" class="form-control">

            </div>

            <div class="col-md-12 mt-4">

                <button class="btn btn-primary">Update Product</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>

            </div>

        </div>

    </form>

@endsection
