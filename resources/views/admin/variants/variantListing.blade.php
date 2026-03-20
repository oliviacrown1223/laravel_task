@extends('admin.panel')

@section('content')

    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
    <!-- Add variants Button -->
    <button class="btn btn-primary mb-3"
            data-bs-toggle="modal"
            data-bs-target="#brandModal"
            style="float:right;">
        Add variants
    </button>

    <h3>variants Data</h3>

    <table class="table table-hover align-middle" style="background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 4px 15px rgba(0,0,0,0.1);">
        <thead style="background: linear-gradient(90deg,#667eea,#764ba2); color:white;">
        <tr>
            <th>ID</th>
            <th>Option Name</th>
            <th>Status</th>
            <th>Value</th>
            <th>Action</th>
        </tr>
        </thead>

        <tbody>
        @foreach($variants as $p)
            <tr>
                <td>{{ $p->id }}</td>

                <td>{{ $p->name }}</td>

                <td>
                    @if($p->status == 1)

                        <a href="{{ route('variants.status',$p->id) }}">
                            <span class="badge bg-success">Active</span>
                        </a>

                    @else

                        <a href="{{ route('variants.status',$p->id) }}">
                            <span class="badge bg-secondary">Inactive</span>
                        </a>

                    @endif
                </td>

                <td>
                    @if($p->values->count())
                        @foreach($p->values as $value)
                            <span class="badge bg-info">{{ $value->value }}</span>
                        @endforeach
                    @else
                        <span class="text-muted">No values</span>
                    @endif
                </td>

                <td>

                        <a href="/variants/edit/{{$p->id}}" class="btn btn-warning btn-sm">
                        Edit
                        </a>

                        <a href="/variants/delete/{{ $p->id }}" class="btn btn-danger btn-sm" style="border-radius:6px; box-shadow:0 2px 6px rgba(0,0,0,0.15);">
                            <i class="fa fa-trash"></i> Delete
                        </a>

                </td>

            </tr>
        @endforeach
        </tbody>
    </table>


    <!-- Add Variants Modal -->

    <div class="modal fade" id="brandModal" tabindex="-1">

        <div class="modal-dialog">

            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Add New Variants</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('variants.store') }}" method="POST">
                    @csrf

                    <!-- Modal Body -->
                    <div class="modal-body">

                        <label>Option Name</label>
                        <input type="text" name="name" class="form-control mb-3" required>

                        <label>Add Value</label>

                        <div class="input-group mb-3">
                            <input type="text" id="valueInput" class="form-control">
                            <button type="button" class="btn btn-primary" onclick="addValue()">Add Value</button>
                        </div>

                        <div id="valuesList"></div>

                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">

                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">
                            Close
                        </button>

                        <button type="submit" class="btn btn-success">
                            Save Variant
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
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

