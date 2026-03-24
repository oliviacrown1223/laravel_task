@extends('admin.panel')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <h3>Add Product</h3>

    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">

            <div class="col-md-6">

                <label>Product Name</label>
                <input type="text" name="name" class="form-control mb-3">

                <label>Price</label>
                <input type="text" name="price" class="form-control mb-3">
            </div>
            <div class="col-md-6">

                <label>Listed Price</label>
                <input type="text" name="listed_price" class="form-control mb-3">

                <label>Description</label>
                <textarea name="Description" class="form-control mb-3"></textarea>



                <label>Brands</label>
                <select name="brands" class="form-control mb-3">

                    <option value="">Select Brand</option>

                    @foreach($brands as $brand)
                        <option value="{{ $brand->id}}">
                            {{ $brand->name }}
                        </option>
                    @endforeach

                </select>
                <label>Categories</label>
                <select name="categories" class="form-control mb-3">

                    <option value="">Select catagory</option>

                    @foreach($categories as $cat)
                        <option value="{{ $cat->id}}">
                            {{ $cat->name }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div class="col-md-6 mt-3">

                <label>Product Image</label>
                <input type="file" name="image" class="form-control">

            </div>
            <div class="col-md-12 mt-4">

                <h5>Variants</h5>

                <div id="variantArea">

                    <div class="row mb-2 variantRow">

                        <div class="col-md-3">
                            <label>Name</label>
                            <select name="variant_name[]" class="form-control variantName">
                                <option value="">Select Options</option>

                                @foreach($variants as $v)
                                    <option value="{{ $v->id }}">
                                        {{ $v->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Value</label>
                            <select name="variant_value[]" class="form-control variantValue">
                                <option value="">Select Variant Value</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label>Stock</label>
                            <input type="number" name="stock[]" class="form-control">
                        </div>

                        <div class="col-md-2">
                            <label>Min-Stock</label>
                            <input type="number" name="min_stock[]" class="form-control">
                        </div>

                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-danger removeRow">-</button>
                        </div>

                    </div>

                </div>

                <button type="button" class="btn btn-warning mt-2" id="addVariant">
                    + Add Variant
                </button>

            </div>

            <div class="col-md-12 mt-4">

                <button class="btn btn-primary">Add Product</button>

            </div>

        </div>

    </form>
    <script>
        let variants = @json($variants);
    </script>
    <script>

        document.addEventListener("change", function(e){

            if(e.target.classList.contains("variantName")){

                let optionId = e.target.value;

                let valueSelect = e.target.closest('.row').querySelector('.variantValue');

                valueSelect.innerHTML = '<option value="">Select Variant Value</option>';

                variants.forEach(function(v){

                    if(v.id == optionId){

                        v.values.forEach(function(val){

                            valueSelect.innerHTML +=
                                `<option value="${val.id}">${val.value}</option>`;

                        });

                    }

                });

            }

        });

    </script>
    <script>

        document.getElementById("addVariant").onclick = function(){

            let area = document.getElementById("variantArea");

            let row = document.querySelector(".variantRow");

            let clone = row.cloneNode(true);

            // clear inputs in new row
            clone.querySelectorAll("input").forEach(function(input){
                input.value = "";
            });

            clone.querySelector(".variantValue").innerHTML =
                '<option value="">Select Variant Value</option>';

            area.appendChild(clone);

        };

    </script>
    <script>

        document.addEventListener("click", function(e){

            if(e.target.classList.contains("removeRow")){

                let rows = document.querySelectorAll(".variantRow");

                if(rows.length > 1){
                    e.target.closest(".variantRow").remove();
                }

            }

        });

    </script>

@endsection
