$(document).ready(function(){

    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    });

    $(document).on('click','.view-btn',function(){
        let productId = $(this).data('id');
        $.ajax({
            url:"/product/show/" + productId,
            type:'GET',
            success:function(response){
                if (response.success) {
                    console.log(response)
                    let product = response.product;
                    $('#view-product-id').text(product.id);
                    $('#view-product-name').text(product.name);
                    $('#view-product-price').text('Rs' + parseFloat(product.price).toFixed(2));
                    $('#view-product-description').text(product.description);
                    $('#view-product-stock').text(product.stock_quantity);
                    $('#view-product-category').text(product.category);
                    if (product.image) {
                        $('#view-product-image').attr('src', "{{ asset('/storage') }}" + '/' + product.image).show();
                    } else {
                        $('#view-product-image').hide();
                    }
                }
            },
            error:function(xhr,status,error){
                
            }
        });
    });

    $('#login').on('click',function(event){
        event.preventDefault();
        let formData = $('#loginForm').serialize();
        $.ajax({
            url:'/auth/login',
            type:'POST',
            data:formData,  
            success:function(response){
                if(response.success){
                    $('#loginModal').modal('hide');
                     window.location.href = response.redirect_url || '/dashboard';
                }
            },
            error:function(xhr,status,error){
                console.log(error);
            }
        });
    });

    $('.logout-btn').on('click',function(){
        $.ajax({
            url:'/auth/logout',
            type:'POST',
            data:{
                _token: csrfToken
            },
            success:function(response){
                if(response.success){
                    $('#loginModal').modal('hide');
                    window.location.href = response.redirect_url || '/dashboard';
                }else{
                    if(response.errors){
                        Object.keys(response.errors).forEach(function(key){
                            $('#' + key).addClass('is-invalid'); // Add 'is-invalid' class to the input field
                            $('#' + key + 'login_error').text(response.errors[key][0])
                        });
                    }
                }
                
            },
            error:function(xhr,status,error){
                // 
            }
        })
    })

    $('#register-btn').on('click', function () {
        let formData = $('#registerForm').serialize();
        $.ajax({
            url: '/auth/register',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#registerModal').modal('hide');
                    window.location.href = response.redirect_url;
                } else {
                    if (response.errors) {
                        Object.keys(response.errors).forEach(function (key) {
                            $('#' + key).addClass('is-invalid'); // Add 'is-invalid' class to the input field
                            $('#' + key + '_error').text(response.errors[key][0]); // Display the first error message for the field
                        });
                    }
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText); // Log any AJAX errors for debugging
            }
        });
    });

    $(document).on('click','.add_to_cart',function(){
        let productId = $(this).data('id');
        $.ajax({
            url:'/cart/add/'+productId,
            type:'POST',
            data:{
                _token: '{{ csrf_token() }}',
                product_id : productId,
                quantity : 1,
            },
            dataType:'json',
            success:function(response){
                if(response.success){
                    console.log(response.success);
                    window.location.href = response.redirect_url;
                }
            },
            error:function(xhr,status,error){
                //
            }
        });
    });

    $('.category_btn').on('click', function () {
        let categoryId = $(this).data('id');
        $.ajax({
            url: '/categories/' + categoryId + '/products', // Corrected endpoint URL
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    let products = response.category.products
                    $('#product_type').text(response.category.name); // Display category name
                    $('.product-list').empty(); // Clear existing products
                    products.forEach(function (product) {
                        // Append product details to product-list
                        let productItem = `
                            <div class="row">
                                <div class="col-md-9 m-auto">
                                    <div class="product-item">
                                        <div class="product-content">
                                            <h3>${product.name}</h3>
                                            <p>Price: ${product.price}</p>
                                             <img src="${product.image_url}" alt="${product.name}" class="img-fluid mb-2" />
                                            <div class="buttons">
                                                <button type="button" class="btn btn-primary btn-sm view-btn" data-id="${product.id}" data-bs-target="#viewModal" data-bs-toggle="modal">View</button>
                                                <button class="btn btn-sm btn-primary add_to_cart" data-id="${product.id}">Add to Cart</button>
                                                <button class="btn btn-sm btn-primary buy_now" data-id="${product.id}">Buy Now</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                        $('.product-list').append(productItem);
                    });
                } else {
                    console.error('Error fetching products:', response.message); // Log error message
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', error); // Log AJAX error
            }
        });
    });
});