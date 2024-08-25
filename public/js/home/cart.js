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
                'action': action
            },
            success: function(response) {
                console.log(response);

                // Ensure response properties exist before accessing them
                let itemTotal = response.cartItem ? response.cartItem.total : 0;
                let subtotal = response.subtotal || 0;
                let total = response.total || 0;
                let quantity = response.cartItem ? response.cartItem.quantity : 0;
                let itemCount = response.cartItems ? response.cartItems.length : 0;

                // Update item total for specific item
                $(`#item-total-${itemId}`).text(response.itemTotalPrice || itemTotal);

                // Update subtotal and total
                $('#subtotal-value').text(subtotal);
                $('#total-value').text(total);

                // Update quantity input
                quantityInput.val(quantity);

                // Remove item if quantity is less than 1
                if (quantity < 1) {
                    $card.remove();
                }

                // Update item count
                $('#item_count').text(itemCount);

                // Display empty cart message if no items left
                if (itemCount === 0) {
                    displayEmptyCartMessage();
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX request failed:', status, error);
            }
        });
    });

});