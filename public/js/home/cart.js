$(document).ready(function(){

    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
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
});