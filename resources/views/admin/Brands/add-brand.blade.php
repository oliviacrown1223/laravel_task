<!-- Add Brand Button -->
<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#brandModal">
    Add Brand
</button>

<!-- Add Brand Modal -->
<div class="modal fade" id="brandModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Brand</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('brand.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <label>Brand Name</label>
                    <input type="text" name="name" class="form-control mb-3">

                    <label>Status</label>
                    <select name="status" class="form-control mb-3">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>

                    <label>Brand Banner Image</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>

        </div>
    </div>
</div>
