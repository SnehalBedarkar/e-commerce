<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Products List</title>

    <!-- Including Bootstrap CSS and DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" > --}}

    <!-- Including jQuery and DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container-fluid">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <h2 class="mb-4">Products List</h2>
        <a href="{{ route('products.create') }}" class="btn btn-primary mb-4">Create Product</a>

        <table class="table table-striped table-bordered" id="myTable">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Image</th>
                    <th scope="col">Name</th>
                    <th scope="col">SKU</th>
                    <th scope="col">Price</th>
                    <th scope="col">Description</th>
                    <th scope="col">Stock Quantity</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr id="product-{{ $product->id }}">
                        <td>{{ $product->id }}</td>
                        <td>
                            @if ($product->image)
                                <img width="25px" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid">
                            @endif
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->sku }}</td>
                        <td>Rs{{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->stock_quantity }}</td>
                        <td class="action-buttons">
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary btn-sm">View</a>
                            <button type="button" class="btn btn-primary btn-sm edit-btn" data-bs-toggle="modal" data-target="#editModal" data-id="{{ $product->id }}">Edit</button>
                            <button type="button" class="btn btn-danger btn-sm delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $product->id }}">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this product?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="editForm">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product->name) }}">
                        </div>
            
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="text" name="price" id="price" class="form-control" value="{{ old('price', $product->price) }}">
                        </div>
            
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control">{{ old('description', $product->description) }}</textarea>
                        </div>
            
                        <div class="mb-3">
                            <label for="stock_quantity" class="form-label">Stock Quantity</label>
                            <input type="number" name="stock_quantity" id="stock_quantity" class="form-control" value="{{ old('stock_quantity', $product->stock_quantity) }}">
                        </div>
            
                        <div class="mb-3">
                            <label for="sku" class="form-label">SKU</label>
                            <input type="text" name="sku" id="sku" class="form-control" value="{{ old('sku', $product->sku) }}">
                        </div>
            
                        <div class="mb-3">
                            <label class="form-lable" for="edit_category_id">Category ID</label>
                            <select class="form-control" name="category_id" id="edit_category_id">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
            
                        <div class="mb-3">
                            <label for="image" class="form-label"></label>
                            <img id="output" width="50px" src="{{ asset('storage/'.$product->image) }}" alt="Current Image" class="img-fluid current-image">
                            <input type="file" onchange="document.querySelector('#output').src=window.URL.createObjectURL(this.files[0])" name="image" id="image" class="form-control">
                        </div>
            
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();

            $('.delete-btn').on('click', function() {
                let productId = $(this).data('id');
                $('#deleteModal').data('id', productId); // Store product ID in the modal
                $('#deleteModal').modal('show');
            });

            

            $('#confirmDelete').on('click', function() {
                let productId = $('#deleteModal').data('id');

                $.ajax({
                    url: '/product/destroy/' + productId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#product-' + productId).remove();
                            $('#deleteModal').modal('hide');
                        } else {
                            // alert('Error deleting product.');
                        }
                    },
                    error: function(err) {
                        console.error('Error deleting product:', err);
                        alert('Error deleting product.');
                    }
                });
            });

            $('.edit-btn').on('click',function(){
                // first get the data id 
                let productId = $(this).data('id');
                // store this id in modal 
                $('#editModal').data('id',productId);
                // and then show the modal 
                $('#editModal').modal('show');
            });

            $('#').on('')
        });
    </script>
</body>
</html>
