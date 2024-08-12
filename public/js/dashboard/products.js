$(document).ready(function(){
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#add_product').on('click',function(e){
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
                    console.log(response);
                    console.log()
    
                    // Reset the form
                    $('#createProductForm')[0].reset();
    
                    // Hide the modal
                    $('#createProductModal').modal('hide');
    
                    // Ensure 'data' exists and is correctly populated
                    let data = response.data; // Assuming your server returns the product data here
                    console.log(data.image);
                    // Create a new row for the table
                    let row = `<tr>
                                    <td><input type="checkbox" class="select-checkbox"></td>
                                    <td>${data.id}</td>
                                    <td>${data.name}</td>
                                    <td><img src="${data.image}" alt="${data.name}" width="100"></td>
                                    <td>${data.description}</td>
                                    <td>${data.price}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-target="#viewModal" data-bs-toggle="modal">View</button>
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#EditModal">Edit</button>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal"> Delete</button>
                                    </td>
                                </tr>`;
    
                    // Append the new row to the table
                    $('#products_table').append(row);
                } else {
                    // Handle the case where response.success is false
                    console.error('Failed to add product:', response.message);
                }
            },
            error:function(){
                // 
            }
        })
    })

    $('#products_table').on('click', '.remove-btn', function() {
        let productId = $(this).data('id');
        $('#confirmProductDelete').data('id', productId);
        $('#productDeleteModal').modal('show');
    });

   
    $('#confirmProductDelete').on('click', function() {
        let productId = $(this).data('id');
        $.ajax({
            url: '/product/destroy',
            type: 'DELETE',
            data: {
                'product_id': productId,
            },
            success: function(response) {
                if (response.success) {
                    $('#productDeleteModal').modal('hide');
                    $('#products_table').find(`tr[data-id="${productId}"]`).remove();
                } else {
                    console.error('Failed to delete product:', response.message);
                }
            },
            error: function(xhr) {
                console.error('Error occurred:', xhr.responseText);
            }
        });
    });


    let selectedProductsIds = [];

    // this is for when user click on all checkbox button all checkoxes is will select
    $('#select-all').on('change',function(){
        let isChecked = $(this).prop('checked');
        $('.select-checkbox').prop('checked',isChecked)
        updateSelectedProductsIds();
    });


    $('#products_table').on('change','.select-checkbox',function(){
        updateSelectedProductsIds();
    });

    function updateSelectedProductsIds() {
        selectedProductsIds = [];
        $('.select-checkbox:checked').each(function() {
            selectedProductsIds.push($(this).data('id'));
        });
    }

    $("#multipleProductsDelete").on('click',function(){
        if(selectedProductsIds.length < 1){
            alert('please select atleaset 1 user');
        }else{
            $('#multipleProductsDeleteModal').modal('show');
        }
    })

    $('#confirmMultipleProductsDelete').on('click',function(){
        $.ajax({
            url:'/prouducts/multiple-delete',
            type:'DELETE',
            data:{
                'ids':selectedProductsIds,
            },
            success:function(response){
                if(response.success === true){
                    console.log(response);
                    if (response.remaining_products === 0) {
                    
                        // Display a message indicating there are no products left
                        $('#products_table').find('tbody').append('<tr><td colspan="7" class="text-center">No products available.</td></tr>');
                    }
                    $('#multipleProductsDeleteModal').modal('hide');
                    selectedProductsIds.forEach(function(id) {
                        $('#products_table').find(`tr[data-id="${id}"]`).remove();
                    });
                    selectedProductsIds = [];
                    
                }
            }
        })
    })
});