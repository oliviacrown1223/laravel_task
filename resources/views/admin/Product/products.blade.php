

@extends('admin.panel')

@section('content')

    <link rel="stylesheet" href="{{ asset('css/table.css') }}">

    <a href="{{ route('product.store') }}"
       class="btn btn-primary"
       style="position:fixed; top:10px; right:20px;">
        Add Product
    </a>
    <h3>Product Data</h3>




    <table class="table table-hover align-middle" style="background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.1);">
        <thead style="background: linear-gradient(90deg,#667eea,#764ba2); color:white;">
        <tr>
            <th>ID</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Image</th>
            <th>Listed Price</th>
            <th>Description</th>
            <th>Brands</th>
            <th>Categories</th>
            <th>Action</th>
        </tr>
        </thead>

        <tbody>
        @foreach($products as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->name }}</td>
                <td>{{ number_format($p->price,2) }}</td>
                <td>
                    @if($p->image)
                        <img src="{{ asset('uploads/products/'.$p->image) }}"
                             width="60" height="60"
                             style="border-radius:8px; object-fit:cover; border:1px solid #ddd;">
                    @else
                        <span class="text-muted">No Image</span>
                    @endif
                </td>
                <td>{{ number_format($p->listed_price,2) }}</td>
                <td>{{ Str::limit($p->Description, 50) }}</td>
                <td>{{ $p->brands }}</td>
                <td>{{ $p->categories }}</td>
                <td>
                    <a href="/edit/{{ $p->id }}" class="btn btn-warning btn-sm me-1" style="border-radius:6px; box-shadow:0 2px 6px rgba(0,0,0,0.15);">
                        <i class="fa fa-edit"></i> Edit
                    </a>
                    <a href="/delete/{{ $p->id }}" class="btn btn-danger btn-sm" style="border-radius:6px; box-shadow:0 2px 6px rgba(0,0,0,0.15);">
                        <i class="fa fa-trash"></i> Delete
                    </a>
                </td>

            </tr>
        @endforeach
        </tbody>
    </table>

@endsection


