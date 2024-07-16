<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" >
    <title>Product List</title>
    <style>
        .header {
            padding: 20px;
            margin-bottom: 20px;
        }
        .create-btn {
            margin-top: 20px;
        }
        .alert-box {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header text-center">
            <div class="heading">
                <h1>List of Product</h1>
            </div>
            <button type="button" class="btn btn-primary btn-sm create-btn"  data-bs-target="#createModal" data-bs-toggle="modal">Add Product</button>
            <div class="alert-box">
                @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif
           </div>
        </div>
        <div class="body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock Quantity</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody #productTable>
                    @foreach ($products as $product)
                    <tr id="product-{{ $product->id }}">
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->stock_quantity }}</td>
                        <td>
                            @if($product->image)
                                <img width="30px" src="{{ asset('storage/' . $product->image) }}" alt=" {{ $product->image }}">
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm view-btn" data-id={{ $product->id }} data-bs-target="#viewModal" data-bs-toggle="modal">View</button>
                            <button type="button" class="btn btn-secondary btn-sm edit-btn" data-id={{ $product->id }} data-bs-target="#editModal" data-bs-toggle="modal">Edit</button>
                            <button type="button" class="btn btn-danger btn-sm delete-btn" data-bs-toggle="modal" data-id="{{ $product->id }}" data-bs-target="#deleteModal">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="footer">

        </div>
    </div>
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="createModalLabel">Add Product</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form id="createProductForm" action="" >
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}">
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
        
                
                <div class="mb-3">
                    <label for="stock_quantity" class="form-label">Stock Quantity</label>
                    <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity') }}">
                    @error('stock_quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
    
                <div class="mb-3">
                    <label for="category_id">Category ID</label>
                    <select name="category_id" id="category_id" class="form-control">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" accept="image/*" id="image" name="image">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>    
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="add-product">Add Product</button>
            </div>
          </div>
        </div>
      </div>
    <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="viewModalLabel">Product Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"></span>
            </button>
            </div>
            <div class="modal-body">
                <div class="product-details">
                    <p><strong>ID:</strong> <span id="view-product-id"></span></p>
                    <p><strong>Name:</strong> <span id="view-product-name"></span></p>
                    <p><strong>Price:</strong> <span id="view-product-price"></span></p>
                    <p><strong>Description:</strong> <span id="view-product-description"></span></p>
                    <p><strong>Stock Quantity:</strong> <span id="view-product-stock"></span></p>
                    <p><strong>Image:</strong> <br><img id="view-product-image" class="img-fluid" width="100px"></p>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"></span>
              </button>
            </div>
            <div class="modal-body">
              Are you sure you want to delete?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="confirmDelete">Delete</button>
            </div>
          </div>
        </div>
      </div>
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"></span>
            </button>
        </div>
        <div class="modal-body">
            <form id="editProductForm" action="{{ route('products.update', ':id') }}" method="POST">
                @csrf
                @method('PUT')
                <!-- Replace :id with actual product ID dynamically -->
                <div class="form-group">
                    <label for="edit-name">Name</label>
                    <input type="text" class="form-control" id="edit-name" name="name">
                </div>
                <div class="form-group">
                    <label for="edit-price">Price</label>
                    <input type="text" class="form-control" id="edit-price" name="price">
                </div>
                <div class="form-group">
                    <label for="edit-stock">Stock Quantity</label>
                    <input type="text" class="form-control" id="edit-stock" name="stock_quantity">
                </div>
                <div class="form-group">
                    <label for="edit-description">Description</label>
                    <textarea class="form-control" id="edit-description" name="description"></textarea>
                </div>
                <div class="form-group">
                    <label for="edit-category">Category</label>
                    <select class="form-control" id="edit-category" name="category_id">
                        <!-- Populate options dynamically from database or backend -->
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit-image">Current Image</label>
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->image }}" class="img-fluid" style="max-width: 200px;">
                    @else
                        <p>No image available</p>
                    @endif
                    <input type="file" name="image" id="edit-image" class="form-control">
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="save-changes">Save changes</button>
        </div>
        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" "></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.view-btn').on('click',function(){
                let productId = $(this).data('id');
                $.ajax({
                    url:"/product/show/" + productId,
                    type:'GET',
                    success:function(response){
                        if (response.success) {
                            let product = response.product;
                            $('#view-product-id').text(product.id);
                            $('#view-product-name').text(product.name);
                            $('#view-product-price').text('Rs' + parseFloat(product.price).toFixed(2));
                            $('#view-product-description').text(product.description);
                            $('#view-product-stock').text(product.stock_quantity);
                            $('#view-product-category').text(product.category);
                            if (product.image) {
                                $('#view-product-image').attr('src', "{{ asset('/storage') }}" + '/' + product.image).show();
                            } else {
                                $('#view-product-image').hide();
                            }
                        }
                    },
                    error:function(err){
                        //
                    }
                });
            });

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
                let productId = $(this).data('id');
                $('#editModal').modal('show');

                $.ajax({
                    url:"/product/edit/"+productId,
                    type:'GET',
                    success:function(response){
                        if(response.success){
                            let product = response.product;
                            $('#edit-name').val(product.name);
                            $('#edit-price').val(product.price);
                            $('#edit-stock').val(product.stock_quantity);
                            $('#edit-description').val(product.description);
                            $('#edit-category').val(product.category_id).change();
                            if (product.image) {
                                $('#current-image').attr('src', '{{ asset('storage/') }}' + '/' + product.image).show();
                            } else {
                                $('#current-image').hide();
                            }
                            $('#editProductForm').attr('action', "{{ url('product/update') }}/" + productId);
                        }
                    },
                    error:function(response){
                        alert('failed in fetching product details');
                    }
                });
            });

            $('.edit-btn').on('click', function() {
                let productId = $(this).data('id'); // Get the product ID from the button's data-id attribute
                $('#editProductForm').attr('action', '/product/update/' + productId); // Update the form action with the product ID
            });

            $('#save-changes').on('click',function(){
                let formElement = $('#editProductForm')[0];
                let formData = new FormData(formElement);
                let productId = $('#editProductForm').attr('action').split('/').pop();
                $.ajax({
                    url:'/product/update/'+productId,
                    type:'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data:formData,
                    processData:false,
                    contentType:false,
                    success:function(response){
                        if(response.success){
                            let product = response.product;
                            let productRow = $('#product-'+productId);
                            productRow.find('td:nth-child(2)').text(product.name);
                            productRow.find('td:nth-child(3)').text(product.price);
                            productRow.find('td:nth-child(4)').text(product.stock_quantity);
                            if (product.image) {
                                productRow.find('td:nth-child(6) img').attr('src', '{{ asset('storage/') }}' + '/' + product.image).show();
                            }
                            $('#editModal').modal('hide');
                        }else{
                            alert('error in updating product');
                        }
                    },
                    error:function(error){
                    }
                })
            })

            $('#add-product').on('click', function() {
                var formData = new FormData($('#createProductForm')[0]);
                $.ajax({
                    url: '/product/store',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            // Add the new product to the table
                            var newRow = `<tr id="product-${response.data.id}">
                                <td>${response.data.name}</td>
                                <td>${response.data.price}</td>
                                <td>${response.data.description}</td>
                                <td>${response.data.stock_quantity}</td>
                                <td>${response.data.category_id}</td>
                                <td>
                                    <img src="${response.data.image}" alt="Product Image" style="max-width: 50px;"/>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit-product" data-id="${response.data.id}">Edit</button>
                                    <button class="btn btn-sm btn-danger delete-product" data-id="${response.data.id}">Delete</button>
                                </td>
                            </tr>`;

                            // Append the new row to the table
                            $('#productTable').append(newRow);

                            // Hide the modal
                            $('#createModal').modal('hide');

                            // Reset form fields to prevent accidental resubmission
                            $('#createProductForm')[0].reset();

                            // Optionally, display a success message or perform other actions
                            $('.alert-box').html('<div class="alert alert-success">Product added successfully!</div>');
                        } else {
                            // Show failure message in alert box
                            $('.alert-box').html('<div class="alert alert-danger">Failed to add product. Please check the form.</div>');
                        }
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 422) {
                            // Unprocessable Entity - validation error
                            var errors = xhr.responseJSON.errors;
                            var errorMessage = 'Validation errors:\n';
                            $.each(errors, function(key, value) {
                                errorMessage += key + ': ' + value + '\n';
                            });
                            console.log(errorMessage);
                        } else {
                            alert('Failed to add product due to an error.');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>