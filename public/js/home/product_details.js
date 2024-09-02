$(document).ready(function(){
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#add-to-cart').on('click', function() {
        let productId = $(this).data('id');
        let quantity = 1; // This should be dynamic if you're using a quantity input

        $.ajax({
            url: '/cart/add',
            type: 'POST',
            data: {
                'product_id': productId,
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

    $('#buy-now').on('click',function(){
        let productId = $(this).data('id');
        let userId = $(this).data('user-id');
        let quantity = 1; // This should be dynamic if you're using a quantity input

        $.ajax({
            url:'/cart/add',
            type:'POST',
            data: {
                'product_id': productId,
                'user_id': userId,
                'quantity': quantity
            },
            success:function(response){
                if(response.success){
                    window.location.href = '/checkout';
                }
            }
        });
    });


    $('#wishlist_button').on('click',function(){
        let productId = $(this).data('id');
        console.log(productId);
        $.ajax({
            url: '/wishlist/add',
            method: 'POST',
            data: {
                'product_id': productId,
            },
            success: function(response) {
                // Determine the type of alert to show based on response success
                let modalBody;

                if (response.success) {
                    // Success message
                    modalBody = `
                        <div class="alert alert-success" role="alert">
                            <strong>Success!</strong> ${response.message}
                        </div>
                    `;
                } else {
                    // Info or warning message
                    modalBody = `
                        <div class="alert alert-info" role="alert">
                            <strong>Info!</strong> ${response.message}
                        </div>
                    `;
                }

                // Insert content into modal body and show the modal
                $('#wishlistModal .modal-body').html(modalBody);
                $('#wishlistModal').modal('show');
            },
            error: function(xhr) {
                // Error message
                let modalBody = `
                    <div class="alert alert-danger" role="alert">
                        <strong>Error!</strong> Failed to add the product to your wishlist. Please try again.
                    </div>
                `;

                // Insert content into modal body and show the modal
                $('#wishlistModal .modal-body').html(modalBody);
                $('#wishlistModal').modal('show');
            }
        });
    });

    // hove zoom effect not working its pending to complete

    // const $img = $('#product-image');
    // const $lens = $('#zoom-lens');
    // const $result = $('#zoom-result');

    // // Set the background image of the result div
    // $result.css('background-image', `url('${$img.attr('src')}')`);

    // $img.on('mouseover', function() {
    //     $lens.show();
    //     $result.show();
    // });

    // $img.on('mousemove', function(e) {
    //     const imgOffset = $img.offset();
    //     const x = e.pageX - imgOffset.left;
    //     const y = e.pageY - imgOffset.top;

    //     const lensWidth = $lens.outerWidth();
    //     const lensHeight = $lens.outerHeight();

    //     // Position the lens
    //     $lens.css({
    //         left: x - lensWidth / 2,
    //         top: y - lensHeight / 2
    //     });

    //     // Calculate the background position of the result
    //     const resultX = (x / $img.width()) * 1000;
    //     const resultY = (y / $img.height()) * 1000;

    //     $result.css({
    //         'background-position': `-${resultX}px -${resultY}px`
    //     });
    // });

    // $img.on('mouseout', function() {
    //     $lens.hide();
    //     $result.hide();
    // });
});
