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
                            <td>Rs${data.price}</td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm view-btn" data-bs-target="#viewModal" data-bs-toggle="modal">View</button>
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
                                        <td>${product.id}</td>
                                        <td>${product.name}</td>
                                        <td><img src="/storage/${product.image}" width="30px"></td>
                                        <td>${product.description}</td>
                                        <td>${product.price}</td>
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

    $("tbody").on('click','.edit-btn',function(){
        let productId = $(this).closest('tr').data('id');
        console.log(productId);
    })
});
