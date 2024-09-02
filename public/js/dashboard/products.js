$(document).ready(function(){
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#add_product').on('click', function(e) {
        e.preventDefault();
        let formData = new FormData($('#createProductForm')[0]);

        $.ajax({
            url:'/product/store',
            type:'POST',
            data:formData,
            processData : false,
            contentType : false,
            success: function(response) {
                if (response.success === true) {
                    $('#createProductForm')[0].reset();
                    $('#createProductModal').modal('hide');
                    let data = response.data;
                    let row = `
                        <tr data-id="${data.id}">
                            <td><input type="checkbox" class="select-checkbox" data-id="${data.id}"></td>
                            <td>${data.id}</td>
                            <td>${data.name}</td>
                            <td><img src="${response.image_url}" alt="${data.name}" width="30px"></td>
                            <td>${data.description}</td>
                            <td>${data.price}</td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm view-btn" data-bs-target="#viewProductModal" data-bs-toggle="modal">View</button>
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#editProductModal">Edit</button>
                                <button type="button" class="btn btn-danger btn-sm remove-btn" data-bs-toggle="modal"  data-bs-target="#productDeleteModal"> Delete</button>
                            </td>
                        </tr>`;
                    $('#tbody').append(row);
                    $('#tbl_msg').remove();
                } else {
                    console.error('Failed to add product:', response.message);
                }
            },
            error:function(){
                console.error('Error occurred while adding the product.');
            }
        });
    });

    $('#tbody').on('click', '.remove-btn', function() {
        const productId = $(this).closest('tr').data('id');
        $('#confirmProductDelete').data('id', productId);
        $('#productDeleteModal').modal('show');
    });

    $('#confirmProductDelete').on('click', function() {
        let productId = $(this).data('id');
        $.ajax({
            url: '/product/destroy',
            type: 'DELETE',
            data: { 'product_id': productId },
            success: function(response) {
                if (response.success) {
                    $('#productDeleteModal').modal('hide');
                    $(`#products_table tr[data-id="${productId}"]`).remove();
                    if ($('#tbody tr').length === 0) {
                        $('#products_table tbody').append('<tr><td colspan="7" class="text-center">No products available.</td></tr>');
                    }
                } else {
                    console.error('Failed to delete product:', response.message);
                }
            },
            error: function(xhr) {
                console.error('Error occurred:', xhr.responseText);
            }
        });
    });

    $('#select-all').on('change', function(){
        let isChecked = $(this).prop('checked');
        $('.select-checkbox').prop('checked', isChecked);
        updateSelectedProductsIds();
    });

    $('#products_table').on('change', '.select-checkbox', function() {
        updateSelectedProductsIds();
    });

    function updateSelectedProductsIds() {
        selectedProductsIds = [];
        $('.select-checkbox:checked').each(function() {
            selectedProductsIds.push($(this).data('id'));
        });
    }

    $("#multipleProductsDelete").on('click', function(){
        if (selectedProductsIds.length < 1) {
            alert('Please select at least 1 product');
        } else {
            $('#multipleProductsDeleteModal').modal('show');
        }
    });

    $('#confirmMultipleProductsDelete').on('click', function() {
        $.ajax({
            url: '/prouducts/multiple-delete',
            type: 'DELETE',
            data: { 'ids': selectedProductsIds },
            success: function(response) {
                if (response.success === true) {
                    selectedProductsIds.forEach(function(id) {
                        $(`#products_table tr[data-id="${id}"]`).remove();
                    });
                    if ($('#tbody tr').length === 0) {
                        $('#products_table tbody').append('<tr><td colspan="7" class="text-center">No products available.</td></tr>');
                    }
                    $('#multipleProductsDeleteModal').modal('hide');
                    selectedProductsIds = [];
                    $('#select-all').prop('checked', false);
                }
            }
        });
    });

    $('#searchQuery').on('input',function(){
        let query =  $(this).val();

        $.ajax({
            url:'/products/search',
            type:'GET',
            // processData : false,
            contentType : false,
            data: {'query':query},
            success:function(response){
                if(response.success === true){
                    console.log(response);
                    let products = response.products
                    $('#products_table tbody').empty();
                    products.forEach((product)=>{
                        let row =  `<tr data-id="${product.id}">
                                        <td class="product_id">${product.id}</td>
                                        <td class="product_name">${product.name}</td>
                                        <td class="product_image"><img src="/storage/${product.image}" width="30px"></td>
                                        <td class="product_description">${product.description}</td>
                                        <td class="product_price">Rs ${product.price}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm view-btn" data-bs-target="#viewProductModal" data-bs-toggle="modal">View</button>
                                            <button type="button" class="btn btn-secondary btn-sm edit-btn" data-bs-toggle="modal" data-bs-target="#editProductModal">Edit</button>
                                            <button type="button" class="btn btn-danger btn-sm remove-btn" data-bs-toggle="modal"  data-bs-target="#productDeleteModal"> Delete</button>
                                        </td>
                                    </tr>`
                    $('#products_table tbody').append(row);
                    });
                }
            }
        })
    })

    $('#tbody').on('click','.view-btn' ,function(){

        let productId = $(this).closest('tr').data('id')
        $.ajax({
            url:'/product/show',
            type:'GET',
            data:{'product_id':productId},
            success:function(response){
                if(response.success === true){
                    console.log(response);
                    let product = response.product[0];
                    $("#viewProdutcModalLabel").text(product.name);
                    $("#product_name").val(product.name);
                    $('#product_price').val(product.price);
                    $('#product_description').val(product.description);
                    $('#product_stock_quantity').val(product.stock_quantity);
                    $('#product_category_id').val(product.category_id);
                    $('#product_image').attr('src', '/storage/' + product.image);
                    $('#image_product_name').val(product.name);
                }
            }
        })
    })

    $('#edit_image').on('change', function(event) {
        var fileInput = $(this)[0];
        var file = fileInput.files[0];
        var imagePreview = $('#new_image_preview');

        if (file) {
            var reader = new FileReader();

            reader.onload = function(e) {
                // Update the preview image src and display it
                imagePreview.attr('src', e.target.result);
                imagePreview.show();
            };

            // Read the file as a data URL
            reader.readAsDataURL(file);
        } else {
            // Hide the preview if no file is selected
            imagePreview.hide();
        }
    });

    $("tbody").on('click','.edit-btn',function(){
        let productId = $(this).closest('tr').data('id');

        $.ajax({
            url:'/product/edit',
            type:'GET',
            data:{
                'product_id':productId
            },
            success:function(response){
                if(response.success === true){
                    let product = response.product[0];
                    $("#edit_product_id").val(product.id);
                    $('#edit_product_name').val(product.name);
                    $('#edit_price').val(product.price);
                    $('#edit_product_description').val(product.description);
                    $('#edit_stock_quantity').val(product.stock_quantity)
                    $('#edit_category_id').val(product.category_id);
                    $('#current_image').attr('src','/storage/'+ product.image);
                    $('#current_image').attr('alt',product.name);
                }
            }
        })
    })

    $('#save_changes').on('click', function() {
        let formData = new FormData($('#editProductForm')[0]);
        $.ajax({
            url:'/product/update', // Ensure this URL is correct
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success === true) {
                    console.log(response);
                    let product = response.product;
                    console.log(product);
                    $('#editProductModal').modal('hide');
                    let row = $(`#products_table tr[data-id="${product.id}"]`);
                    row.find('td.product_id').text(product.id);
                    row.find('td.product_name').text(product.name);
                    row.find('td.product_image img').attr('src', `/storage/${product.image}`);
                    row.find('td.product_description').text(product.description);
                    row.find('td.product_price').text(`Rs${product.price}`);
                }else{
                    if(response.success === false){
                        //
                    }
                }
            },
            error: function() {
                alert('An error occurred while updating the product.');
            }
        });
    });

        // Function to render specifications based on the selected type
        function renderSpecifications(type) {
            var specificationsHtml = '';

            if (type === 'mobile') {
                specificationsHtml = `
                    <div class="specification-item form-row mb-2">
                        <div class="col">
                            <input type="text" class="form-control" name="specifications[][key]" placeholder="Feature" required>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" name="specifications[][value]" placeholder="Value" required>
                        </div>
                        <button type="button" class="btn btn-danger btn-sm ml-2 removeSpecification">Remove</button>
                    </div>
                `;
            } else if (type === 'laptop') {
                specificationsHtml = `
                    <div class="specification-item form-row mb-2">
                        <div class="col">
                            <input type="text" class="form-control" name="specifications[][key]" placeholder="Processor" required>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" name="specifications[][value]" placeholder="Details" required>
                        </div>
                        <button type="button" class="btn btn-danger btn-sm ml-2 removeSpecification">Remove</button>
                    </div>
                `;
            } else if (type === 'tv') {
                specificationsHtml = `
                    <div class="specification-item form-row mb-2">
                        <div class="col">
                            <input type="text" class="form-control" name="specifications[][key]" placeholder="Resolution" required>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" name="specifications[][value]" placeholder="Details" required>
                        </div>
                        <button type="button" class="btn btn-danger btn-sm ml-2 removeSpecification">Remove</button>
                    </div>
                `;
            }

            $('#specificationsContainer').html(specificationsHtml);
        }

        // Update specifications fields based on the selected type
        $('#type').change(function () {
            var selectedType = $(this).val();
            renderSpecifications(selectedType);
        });

        // Add new specification field
        $('#addSpecification').click(function () {
            var type = $('#type').val();
            if (type) {
                var specificationHtml = `
                    <div class="specification-item form-row mb-2">
                        <div class="col">
                            <input type="text" class="form-control" name="specifications[][key]" placeholder="Key" required>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" name="specifications[][value]" placeholder="Value" required>
                        </div>
                        <button type="button" class="btn btn-danger btn-sm ml-2 removeSpecification">Remove</button>
                    </div>
                `;
                $('#specificationsContainer').append(specificationHtml);
            } else {
                alert('Please select a product type first.');
            }
        });
});
