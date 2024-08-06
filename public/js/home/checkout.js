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
        console.log(itemId);
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
                    $('#total').text('Total :  ' + response.total);''
                    $('#amount').val(response.total);
                }
            }
        })

    });

});