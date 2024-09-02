$(document).ready(function(){
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });

    // $('#place_order').on('click',function(){
    //     let userId = $(this).data('user-id');
    //     $.ajax({
    //             url:'/order/add',
    //             type:'POST',
    //             data:{
    //                 'user_id':userId,
    //                 'address_id':address_id,
    //             },
    //             success:function(response){
    //                 if(response.success){
    //                     window.location.href = response.redirect_url;
    //                 }
    //             }
    //     })
    // })

    $('.cart-item').each(function() {
        const itemId = $(this).attr('id');
    });

    $('.update').on('click',function(){
        let action = $(this).data('action');
        let $card = $(this).closest('.cart-item');
        let userId = $card.find('.user-id').val();
        let productId = $card.find('.product-id').val();
        itemId = $card.attr('id');
        let quantityInput = $card.find('.quantity-input');

        $.ajax({
            url: '/checkout/update',
            type: 'PUT',
            data: {
                'user_id': userId,
                'product_id': productId,
                'item_id': itemId,
                'action': action,
            },
            success:function(response){
                if(response.success){
                    console.log(response);
                    quantityInput.val(response.new_quantity);
                    $('#item-total-' + itemId).text(response.new_total);
                    $('#items_count').text('(' + response.itemsCount + ' items)');
                    $('#subtotal-value').text(response.subtotal);
                    if (response.new_quantity === 0) {
                        $card.remove();
                    }
                    $('#deliveryCharges').text('Delivery Charges : ' + response.deliveryCharges);
                    $('#final_amount').text('Total :  ' + response.total);
                    $('#total_amount').val(response.total);
                    // $('#amount').val(response.total);
                }
            }
        })

    });

    let address_id = null;

    $('#pay_button').on('click', function(e) {
        e.preventDefault();

        address_id = $('input[name="address"]:checked').val();
        if(!address_id){
            alert('please select at least one address');
            return;
        }
        var total = $('#total_amount').val() * 100; // Total amount in paise (subunits)
        if (!window.RAZORPAY_KEY_ID) {
            alert('Razorpay key is missing!');
            return;
        }
        var options = {
            "key":window.RAZORPAY_KEY_ID, // Enter the Key ID generated from the Dashboard
            "amount": total, // Amount is in currency subunits (i.e., 100 paise = 1 INR)
            "currency": "INR",
            "name": "ClayWork",
            "description": "Payment for Order",
            "image": "https://example.com/your_logo",
            "handler": function (response){
                if(response.razorpay_payment_id){
                    let payment_id = response.razorpay_payment_id;
                    $.ajax({
                        url:'order/add',
                        type:'POST',
                        data:{
                            'payment_id':payment_id,
                            'address_id':address_id
                        },
                        success:function(response){
                            if(response.success){
                                window.location.href = response.redirect_url
                            }
                        }
                    })
                }
            },
            "prefill": {
                "name": window.username,
            },
            "theme": {
                "color": "#3399cc"
            }
        };

        var rzp1 = new Razorpay(options);
        rzp1.open();
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
                if(response.success === true){
                    $("#login_modal").modal('hide');
                    window.location.reload();
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


    $('#add_address').on('click', function() {
        $('#addAddressModal').modal('show');
    });

    $('#save_deliver').on('click', function() {
        var formData = $('#address_form').serialize(); // Serialize form data

        $.ajax({
            url:'/user/address-store',
            type: 'POST',
            data: formData,
            success: function(response) {
                if(response.success === true){
                    $('#addNewAdderessModal').modal('hide');
                }
            },
            error: function(xhr, status, error) {
                alert('An error occurred. Please try again.');
            }
        });
    });

    $(".edit-btn").on('click',function(){
        let address_id = $(this).data('id');
        $('#editAddressModal').modal('show');

        $.ajax({
            url:'/user/address',
            type:'GET',
            data:{'address_id':address_id},
            success:function(response){
                if(response.success === true){
                    let address = response.address;
                    $('#edit_address_id').val(address.id);
                    $('#edit_name').val(address.name);
                    $('#edit_phone_number').val(address.phone_number);
                    $('#edit_postal_code').val(address.postal_code);
                    $('#edit_locality').val(address.locality);
                    $('#edit_address').val(address.address);
                    $('#edit_city').val(address.city);
                    $('#edit_state').val(address.state);
                    $('#edit_landmark').val(address.landmark);
                    $('#edit_alt_phone_number').val(address.alternate_phone_number);
                    $(`input[name="type"][value="${address.type}"]`).prop('checked', true);
                }
            }
        })
    })

    $('#save_changes').on('click',function(){
        let formData = $('#edit_address_form').serialize();

        $.ajax({
            url:'/user/address-update',
            type:'PUT',
            data:formData,
            success:function(response){
                if(response.success === true){
                    $("#editAddressModal").modal('hide');
                    alert(response.message);
                }
            }
        })
    });


});
