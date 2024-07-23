<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home/home.css') }}">
</head>
<body>
    <div class="container">
        @include('home.layouts.header')
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
                                                {{-- <button class="btn btn-sm btn-primary buy_now" data-id="{{ $product->id }}" data-user-id="{{ Auth::user()->id }}">Buy Now</button> --}}
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

    @include('home.partials.modals')
    
    <!-- JavaScript and dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/home.js') }}"></script>
</body>
</html>
