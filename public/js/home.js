$(document).ready(function(){
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#orders_table').DataTable();

    $('#togglePassword').on('click', function() {
        var passwordField = $('#register_password');
        var type = passwordField.attr('type') === 'password' ? 'text' : 'password';
        passwordField.attr('type', type);
        $(this).find('i').toggleClass('fa-eye fa-eye-slash');
    });

    $('#togglePasswordConfirmation').on('click', function() {
        var passwordConfirmationField = $('#password_confirmation');
        var type = passwordConfirmationField.attr('type') === 'password' ? 'text' : 'password';
        passwordConfirmationField.attr('type', type);
        $(this).find('i').toggleClass('fa-eye fa-eye-slash');
    });

    $('#login_button').on('click',function(e){
        e.preventDefault();

        // Clear previous error messages
        $("#login_email_error").text('');
        $("#login_password_error").text('');

        let formData = $('#login_form').serialize();
        $.ajax({
            url:'/auth/login',
            type:'POST',
            data:formData,
            success:function(response){
                if(response.success){
                    $("#login_modal").modal('hide');
                    window.location.href = response.redirect_url;
                }else if(response.errors){
                    let errors = response.errors;
                    console.log(errors);
                    errors.forEach((error)=>{
                        if(error.includes('email')){
                            $("#login_email_error").text(error);
                        }else if(error.includes('password')){
                            $("#login_password_error").text(error);
                        }
                    })
                }
            },
            error:function(error){
                console.log(error);
            }
        })
    })

    $('#register_button').on('click',function(event){
        event.preventDefault();
        let formData = $('#register_form').serialize();

        // clear the previous errors
        $('.text-danger').text('');
        
        $.ajax({
            url:'/auth/register',
            type:'POST',
            data:formData,
            success:function(response){
                if(response.success){
                    window.location.href = response.redirect_url;
                }else{
                    let errors = response.errors;
                    errors.forEach((error)=>{
                        if(error.includes('name')){
                            $('#register_name_error').text(error)
                        }else if(error.includes('email')){
                            $('#register_email_error').text(error)
                        }else if(error.includes('confirmation')){
                            $('#password_confirmation_error').text(error)
                        }else if(error.includes('passoword')){
                            $('#password_password_error').text(error)
                        }else if(error.includes('phone')){
                            $('#phoone_number_error').text(error)
                        }else {
                            $('.text-danger').text('');
                        }
                    })
                    console.log(response.errors)
                }
            },
            error: function(xhr,status,error) {
              //
            }
        });
    });

    $('#logout_button').on('click',function(){
        $.ajax({
            url:'/auth/logout',
            type:'POST',
            success:function(response){
                if(response.success){
                    window.location.href = response.redirect_url;
                    $('#header_message').html('<div class="alert alert-success">' + response.message + '</div>');
                    setTimeout(() => {
                        $('#header_message').html('');
                    }, 4000);
                }
            },
            error:function(xhr,status,error){
                console.log(xhr,status,error);
            }
        });
    });

    $('.add-to-cart').on('click', function() {
        let productId = $(this).data('id');
        let userId = $(this).data('user-id');
        let quantity = 1; // This should be dynamic if you're using a quantity input
    
        $.ajax({
            url: '/cart/add',
            type: 'POST',
            data: {
                'product_id': productId,
                'user_id': userId,
                'quantity': quantity
            },
            success: function(response) {
                if (response.success) {
                    window.location.href = response.redirect_url;
                } else if (response.authenticated === false) {
                    $('#loginModal').modal('show');
                } else {
                    // Handle other types of errors or responses here
                    console.log(response.errors);
                }
            },
            error: function(xhr, status, error) {
                // Handle errors here, such as logging them or showing a user-friendly message
                console.error('AJAX error:', status, error);
                alert('An error occurred while processing your request. Please try again.');
            }
        });
    }); 


    $('.remove_item').on('click',function(){
        let userId = $(this).data('user-id');
        let itemId = $(this).data('id');
        

        $("#remove_button").data('user-id', userId);
        $("#remove_button").data('item_id', itemId);

    });
    
    const emptyCartMessage = `  <p class="test">Your cart is empty</p> `;
    const button = `<div class="text-center"><a href="${ window.homePageUrl}" class="btn btn-secondary btn-lg active" role="button" aria-pressed="true">Shop Now</a></div>`;

    function displayEmptyCartMessage() {
        $('#container').html(emptyCartMessage+button);
        $('#price-datails').remove();
    }

    $('#remove_button').on('click',function(){
        let userId = $(this).data('user-id');
        let itemId = $(this).data('item_id');
        $.ajax({
            url:'/cart/remove',
            type:'DELETE',
            data :{
                'user_id':userId,
                'item_id':itemId,
            },
            success:function(response){
                if(response.success){
                    let total = response.total;
                    let cartItems = response.cartItems;
                    if(cartItems.length === 0){
                        displayEmptyCartMessage()
                    }
                    $('#cartRemoveModal').modal('hide');
                    $(`[data-item-id="${response.cartItem.id}"]`).remove();
                    $('#total-value').text(total);
                }
            },
            error:function(){
                // 
            }
        })
    });

    $('.update').on('click', function() {
        let action = $(this).data('action');
        let $card = $(this).closest('.cart-item');
        let userId = $card.find('.user-id').val();
        let productId = $card.find('.product-id').val();
        let itemId = $card.find('.item-id').val();
        let quantityInput = $card.find('.quantity-input');

        $.ajax({
            url: '/cart/update',
            type: 'PUT',
            data: {
                'user_id': userId,
                'product_id': productId,
                'item_id': itemId,
                'action': action,
            },
            success: function(response) {
                console.log(response);
                let itemTotal = response.cartItem ? response.cartItem.total : 0;
                let subtotal = response.subtotal;
                let total = response.total;
               
                $('#item-total-').text(itemTotal);
                $('#item-total-'+itemId).text(response.itemTotalPrice);

                // Update the subtotal and total values
               
                $('#subtotal-value').text(subtotal);
                $('#total-value').text(total);


                let quantity = response.cartItem.quantity;
                quantityInput.val(quantity);
                if (quantity === 0) {
                    $card.remove(); // Use the $card selector to remove the item
                }


                let itemCount = response.cartItems ? response.cartItems.length : 0;
                $('#item_count').text(itemCount);
                if(itemCount === 0){
                    displayEmptyCartMessage();
                }
            }
        });
    });
    
    $('#place_order').on('click',function(){
       let userId = $(this).data('user-id');
       $.ajax({
            url:'/order/add',
            type:'POST',
            data:{
                'user_id':userId,
            },
            success:function(response){
                if(response.success){
                    window.location.href = response.redirect_url;
                }
            }
       })
    })

    $('#submit_status').on('click', function() {
        let selectedStatuses = [];
        $('#orders_status input[name="orders_status[]"]:checked').each(function() {
            selectedStatuses.push($(this).val());
        });

        console.log(selectedStatuses);
        $.ajax({
            url: '/orders/status',
            type: 'GET',
            data: {
                statuses: selectedStatuses,
            },
            success: function(response) {
                if (response.success) {
                    console.log(response.success);
                    $('#main_content').html('');
                }
            },
            error: function(response) {
                console.error(response);
            }
        });
    });
    
});
    

