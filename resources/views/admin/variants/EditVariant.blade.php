@extends('admin.panel')

@section('content')

    <h3>Edit Variant</h3>

    <form action="{{ route('variants.update',$variants->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="modal-body">

            <label>Option Name</label>
            <input type="text" name="name" value="{{ $variants->name }}" class="form-control mb-3">

            <label>Add Value</label>

            <div class="input-group mb-3">
                <input type="text" id="valueInput" class="form-control">
                <button type="button" class="btn btn-primary" onclick="addValue()">Add Value</button>
            </div>

            <!-- Existing Values -->
            <div id="valuesList">

                @foreach($variants->values as $value)

                    <div class="d-flex mb-2">
                        <input type="hidden" name="values[]" value="{{ $value->value }}">
                        <input type="text" class="form-control" value="{{ $value->value }}" readonly>
                        <button type="button" class="btn btn-danger ms-2" onclick="this.parentElement.remove()">🗑</button>
                    </div>

                @endforeach

            </div>

        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-success">
                Update Variant
            </button>
        </div>

    </form>


    <script>

        function addValue(){

            let value = document.getElementById("valueInput").value;

            if(value == "") return;

            let html = `
    <div class="d-flex mb-2">
        <input type="hidden" name="values[]" value="${value}">
        <input type="text" class="form-control" value="${value}" readonly>
        <button type="button" class="btn btn-danger ms-2" onclick="this.parentElement.remove()">🗑</button>
    </div>
    `;

            document.getElementById("valuesList").insertAdjacentHTML('beforeend',html);

            document.getElementById("valueInput").value="";

        }

    </script>

@endsection
