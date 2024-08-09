$(document).ready(function(){
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
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

    $('#pay_button').on('click', function(e) {
        e.preventDefault();

        var total = $('#total_amount').val() * 100; // Total amount in paise (subunits)
        if (!window.RAZORPAY_KEY_ID) {
            alert('Razorpay key is missing!');
            return;
        }

        var options = {
            "key":window.RAZORPAY_KEY_ID, // Enter the Key ID generated from the Dashboard
            "amount": total, // Amount is in currency subunits (i.e., 100 paise = 1 INR)
            "currency": "INR",
            "name": "Your Company Name",
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

});