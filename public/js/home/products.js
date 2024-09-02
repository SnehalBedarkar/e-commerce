$(document).ready(function(){
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });

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

    $('.card').on('click',function(){
        let product_id = $(this).data('id');
        $.ajax({
            url:'/product/views',
            type:'POST',
            data:{'product_id':product_id},
            success:function(response){
                if(response.success === true){
                    console.log(response);
                }
            }
        })
    });



   // Function to handle sorting
    $('.btn').on('click', function() {
        var categoryId = $(this).data('id');
        var sortType = $(this).data('action');

        $.ajax({
            url: '/products/sort',
            method: 'GET',
            data: {
                category_id: categoryId,
                sort: sortType,
            },
            success: function(response) {
                console.log(response);
                $('#product_list').empty();

                let products = response.products;
                products.forEach((product) => {
                    let card = `
                        <div class="col-12 mb-4 ms-auto">
                            <a href="/product/details/${product.id}" class="text-decoration-none">
                                <div class="card shadow-sm border-0" data-id="${product.id}">
                                    <div class="row justify-content-around">
                                        <div class="col-2  align-self-center position-relative">
                                            <img src="/storage/${product.image}" class="img-fluid rounded-start img-thumbnail mb-2 mt-2" alt="${product.name}" style="width: 100px; height: auto;">
                                            <button class="btn btn-light position-absolute top-0 end-0 m-2 wishlist-button" data-id="${product.id}">
                                                <i class="fas fa-heart wishlist-icon"></i> <!-- FontAwesome heart icon -->
                                            </button>
                                        </div>
                                        <div class="col-6 align-self-auto">
                                            <h5 class="card-title mb-0">${product.name}</h5>
                                        </div>
                                        <div class="col-2 align-self-auto">
                                            <p class="card-text mb-0"><strong>Rs ${product.price}</strong></p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    `;
                    $('#product_list').append(card);
                });
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText); // Handle errors
            }
        });
    });

    $("#product_list").on('click', '.wishlist-button', function(event) {
        event.preventDefault();
        event.stopPropagation();

        let button = $(this);
        let productId = button.data('id');
        let icon = button.find('.wishlist-icon');
        let isInWishlist = icon.hasClass('text-danger');

        $.ajax({
            url: isInWishlist ? '/wishlist/remove' : '/wishlist/add',
            method: 'POST',
            data: {
                'product_id': productId,
            },
            success: function(response) {
                let modalBody;

                if (response.success === true) {
                    // Toggle the heart icon's color
                    if (isInWishlist) {
                        icon.removeClass('text-danger');
                    } else {
                        icon.addClass('text-danger');
                    }

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
                        <strong>Error!</strong> Failed to update the wishlist. Please try again.
                    </div>
                `;

                // Insert content into modal body and show the modal
                $('#wishlistModal .modal-body').html(modalBody);
                $('#wishlistModal').modal('show');
            }
        });
    });



})
