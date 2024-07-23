$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // View Button Click Handler
    $('.view-btn').on('click', function(){
        let productId = $(this).data('id');
        $.ajax({
            url: `/product/show/${productId}`,
            type: 'GET',
            success: function(response){
                if (response.success) {
                    let product = response.product;
                    $('#view-product-id').text(product.id);
                    $('#view-product-name').text(product.name);
                    $('#view-product-price').text('Rs ' + parseFloat(product.price).toFixed(2));
                    $('#view-product-description').text(product.description);
                    $('#view-product-stock').text(product.stock_quantity);
                    $('#view-product-category').text(product.category);
                    if (product.image) {
                        $('#view-product-image').attr('src', `{{ asset('storage') }}/${product.image}`).show();
                    } else {
                        $('#view-product-image').hide();
                    }
                }
            },
            error: function(xhr, status, error){
                console.error('Error fetching product details:', error);
            }
        });
    });

    // Delete Button Click Handler
    $('.delete-btn').on('click', function() {
        let productId = $(this).data('id');
        $('#deleteModal').data('id', productId); // Store product ID in the modal
        $('#deleteModal').modal('show');
    });

    // Confirm Delete Button Click Handler
    $('#confirmDelete').on('click', function() {
        let productId = $('#deleteModal').data('id');

        $.ajax({
            url: `/product/destroy/${productId}`,
            type: 'DELETE',
            success: function(response) {
                if (response.success) {
                    $(`#product-${productId}`).remove();
                    $('#deleteModal').modal('hide');
                    $('#delete_close_modal').click();
                    
                } else {
                    alert('Error deleting product.');
                }
            },
            error: function(err) {
                console.error('Error deleting product:', err);
                alert('Error deleting product.');
            }
        });
    });

    // Edit Button Click Handler
    $('.edit-btn').on('click', function() {
        let productId = $(this).data('id');
        $('#editModal').modal('show');

        $.ajax({
            url: `/product/edit/${productId}`,
            type: 'GET',
            success: function(response){
                if(response.success){
                    let product = response.product;
                    $('#edit-name').val(product.name);
                    $('#edit-price').val(product.price);
                    $('#edit-stock').val(product.stock_quantity);
                    $('#edit-description').val(product.description);
                    $('#edit-category').val(product.category_id).change();
                    if (product.image) {
                        $('#current-image').attr('src', `{{ asset('storage') }}/${product.image}`).show();
                    } else {
                        $('#current-image').hide();
                    }
                    $('#editProductForm').attr('action', `/product/update/${productId}`);
                }
            },
            error: function(response){
                alert('Failed to fetch product details.');
            }
        });
    });

    // Save Changes Button Click Handler
    $('#save-changes').on('click', function(){
        let formElement = $('#editProductForm')[0];
        let formData = new FormData(formElement);
        let productId = $('#editProductForm').attr('action').split('/').pop();

        $.ajax({
            url: `/product/update/${productId}`,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            processData: false,
            contentType: false,
            success: function(response){
                if(response.success){
                    let product = response.product;
                    let productRow = $(`#product-${productId}`);
                    productRow.find('td:nth-child(2)').text(product.name);
                    productRow.find('td:nth-child(3)').text(product.price);
                    productRow.find('td:nth-child(4)').text(product.stock_quantity);
                    if (product.image) {
                        productRow.find('td:nth-child(5) img').attr('src', `{{ asset('storage') }}/${product.image}`).show();
                    }
                    $('#editModal').modal('hide');
                } else {
                    alert('Error updating product.');
                }
            },
            error: function(error){
                console.error('Error updating product:', error);
            }
        });
    });

    // Add Product Button Click Handler
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
                        <td>${response.data.id}</td>
                        <td>${response.data.name}</td>
                        <td>${response.data.price}</td>
                        <td>${response.data.stock_quantity}</td>
                        <td>
                            <img src="${response.data.image}" alt="Product Image" style="max-width: 50px;"/>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary edit-btn" data-id="${response.data.id}" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                            <button class="btn btn-sm btn-danger delete-btn" data-id="${response.data.id}" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete</button>
                        </td>
                    </tr>`;

                    // Append the new row to the table
                    $('#productTable').append(newRow);

                    // Hide the modal
                    $('#createModal').modal('hide');

                    // Reset form fields
                    $('#createProductForm')[0].reset();

                    // Display success message
                    $('.alert-box').html('<div class="alert alert-success">Product added successfully!</div>');
                } else {
                    $('.alert-box').html('<div class="alert alert-danger">Failed to add product. Please check the form.</div>');
                }
            },
            error: function(xhr, status, error) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    var errorMessage = 'Validation errors:\n';
                    $.each(errors, function(key, value) {
                        errorMessage += `${key}: ${value}\n`;
                    });
                    console.log(errorMessage);
                } else {
                    alert('Failed to add product due to an error.');
                }
            }
        });
    });
});
