{{--<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ClayWork</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles can be added here */
        .header {
            padding: 10px 0;
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }
        .logo {
            /* Add styles for logo */
        }
        .functionalities {
            /* Add styles for header functionalities */
        }
        .functionalities ul {
            display: flex;
            list-style-type: none;
            margin: 0;
            padding: 0;
        }
        .functionalities {
            text-align: right; /* Align navigation to the right */
        }
        .nav {
            display: flex;
            align-items: center; /* Align items vertically in the nav */
            list-style-type: none;
            margin: 0;
            padding: 0;
        }
        .nav-item {
            margin-right: 10px; /* Adjust spacing between navigation items */
        }

        .btn-primary {
            background-color: #007bff; /* Blue primary button color */
            color: #fff; /* White text color */
            border-color: #007bff; /* Matching border color */
            transition: background-color 0.3s ease; /* Smooth transition on hover */
        }


        .btn-primary:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }

        .btn-outline-danger {
            color: #dc3545; /* Red danger button text color */
            border-color: #dc3545; /* Matching border color */
        }

        .btn-outline-danger:hover {
            color: #fff; /* White text on hover */
            background-color: #dc3545; /* Red background on hover */
            border-color: #dc3545; /* Matching border color on hover */
        }
        .nav-link {
            text-decoration: none; /* Remove underline from links */
        }
        .product-list {
            margin-top: 20px;
        }
        .product-item {
            display: flex;
            border: 1px solid #ccc;
            padding: 16px;
            margin-bottom: 16px;
            /* width: 300px;  */
        }

        .product-content {
            flex: 1; /* Takes up remaining space in the flex container */
        }

        .product-item h3, .product-item p {
            margin: 0 0 8px 0;
        }

        .product-image {
            width: 100px; /* Adjust image width as needed */
            align-self: flex-start; /* Align image to the start (top) of its container */
            margin-left: auto; /* Pushes the image to the right */
        }

        .buttons {
            margin-top: auto; /* Push buttons to the bottom of their container */
            display: flex;
            /* flex-direction: column; */
            gap: 10px;
            align-items: flex-end;
        }


    </style>
</head>
<body>
    <div class="container">
        <div class="header">

            <div class="logo">
                <h1><span class="company-name">ClayWork</span></h1>
            </div>
            
            <div class="functionalities right">
                
                <ul class="nav">
                    @auth
                    <div class="dropdown text-end">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ explode(' ', Auth::user()->name)[0] }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="{{ route('user.show', Auth::user()->id) }}">My Profile</a></li>
                            <li><a class="dropdown-item" href="#">Orders</a></li>
                            <li><a class="dropdown-item" href="">Wishlist</a></li>
                            <li class="nav-item">
                                <button type="button" class="btn btn-outline-danger logout-btn">Logout</button>
                            </li>
                        </ul>
                    </div>
                        <li class="nav-item">
                            <a href="{{ route('cart.index') }}" class="nav-link btn btn-primary">
                                Cart
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">
                                Login
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registerModal">
                                Register
                            </button>
                        </li>
                    @endauth
                </ul>
            </div>
            
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="sidebar">
                    <div class="container">
                        <h3>Categories</h3>
                        <ul class="nav flex-column">
                            @foreach ($categories as $category)
                            <li class="nav-item mb-3">
                                <button type="button" class="btn btn-primary category_btn" data-id="{{ $category->id }}">{{$category->name }}</button>         
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="main-content">
                    <!-- Display products -->
                    <h2 id="product_type"></h2>
                    <div class="product-list">
                        @if ($products->isEmpty())
                            <p>No products found.</p>
                        @else
                            @foreach ($products as $product)
                            <div class="row">
                                <div class="col-md-9 m-auto">
                                    <div class="product-item">
                                        <div class="product-content">
                                            <h3 id="product-name">{{ $product->name }}</h3>
                                            <p>Price: {{ $product->price }}</p>
                                            <div class="buttons">
                                                <button type="button" class="btn btn-primary btn-sm view-btn" data-id="{{ $product->id }}" data-bs-target="#viewModal" data-bs-toggle="modal">View</button>
                                                <button class="btn btn-sm btn-primary add_to_cart" data-id="{{ $product->id }}">Add to Cart</button>
                                                <button class="btn btn-sm btn-primary buy_now" data-id="{{ $product->id }}" data-user-id="{{ Auth::user()->id }}">Buy Now</button>
                                            </div>
                                        </div>
                                        <img class="product-image" src="{{ asset('storage/' . $product->image) }}" alt="">
                                    </div>  
                                </div>
                            </div>                        
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="footer">
            <!-- Add footer content -->
            <p>&copy; 2024 Your Company Name. All rights reserved.</p>
        </div>
    </div>

    <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="viewModalLabel">Product Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"></span>
            </button>
            </div>
            <div class="modal-body">
                <div class="product-details">
                    <p><strong>Name:</strong> <span id="view-product-name"></span></p>
                    <p><strong>Price:</strong> <span id="view-product-price"></span></p>
                    <p><strong>Description:</strong> <span id="view-product-description"></span></p>
                    <p><strong>Image:</strong> <br><img id="view-product-image" class="img-fluid" width="100px"></p>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="loginModalLabel">Login Form</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="loginForm">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="login_email" name="email" value="{{ old('email') }}" placeholder="Enter Email" autocomplete="username">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="login_password" name="password" placeholder="Enter Password" autocomplete="current-password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="login">Login</button>
            </div>
          </div>
        </div>
    </div>
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="registerModalLabel">Register User</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="registerForm">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="register_email" name="email" value="{{ old('email') }}" autocomplete="username">
                        <span id="email_error"></span>
                    </div>
    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="register_password" name="password" autocomplete="new-password">
                        <span id="password_error"></span>
                    </div>
    
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
                    </div>
    
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number') }}">
                        <span id="phone_number_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="register-btn">Register</button>
            </div>
          </div>
        </div>
      </div>
    
    <!-- JavaScript and dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function(){
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
                    data:{_token: '{{ csrf_token() }}'},
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
    </script>
</body>
</html>
--}}

@extends('home.layouts.master')
@section('content')

@endsection



