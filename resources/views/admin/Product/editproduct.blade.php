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
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id}}">
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
                <label>categories</label>
                <select name="categories" class="form-control mb-3">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id}}">
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>

            </div>

            <div class="col-md-6 mt-3">
                <label>Current Image</label><br>

                <img id="previewImage"
                     src="{{ asset('uploads/products/'.$data->image) }}"
                     width="100"
                     height="100"
                     style="border-radius:8px; object-fit:cover; border:1px solid #ddd;">
            </div>

            <div class="col-md-6 mt-3">
                <label>Change Image</label>
                <input type="file" name="image" id="imageInput" class="form-control" accept="image/*">
            </div>

            <div class="col-md-12 mt-4">

                <button class="btn btn-primary">Update Product</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>

            </div>

        </div>

    </form>

@endsection

<script>
    document.getElementById('imageInput').addEventListener('change', function(e) {

        let file = e.target.files[0];

        if (file) {
            let reader = new FileReader();

            reader.onload = function(event) {
                document.getElementById('previewImage').src = event.target.result;
            };

            reader.readAsDataURL(file);
        }

    });
</script>
