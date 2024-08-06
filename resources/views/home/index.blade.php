@extends('layouts.master')

@section('title', 'Home')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/home/index.css')}}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css')}}">
@endpush

@section('header')
    @include('partials.home.header')
@endsection

@section('sidebar')
    @include('partials.home.sidebar')
@endsection

@section('content')
    <section class="hero">
        <div class="hero-content">
            <h1>Welcome to Claywork</h1>
            <p>Your one-stop shop for unique and handcrafted clay products.</p>
            <a href="/shop" class="btn-primary">Shop Now</a>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="featured-products">
        <div class="container">
            <h2>Featured Products</h2>
            <div class="product-grid">
                <div class="product-card">
                    {{-- <img src="{{ asset('storage/'.$product->image) }}" alt="Product 1"> --}}
                    <h3>Product 1</h3>
                    <p>$25.00</p>
                    <a href="/product/1" class="btn-secondary">View Details</a>
                </div>
                <div class="product-card">
                    <img src="path/to/image2.jpg" alt="Product 2">
                    <h3>Product 2</h3>
                    <p>$30.00</p>
                    <a href="/product/2" class="btn-secondary">View Details</a>
                </div>
                <!-- Add more product cards as needed -->
            </div>
        </div>
    </section>
@endsection

@section('footer')
    @include('partials.home.footer')
@endsection

@section('modals')
    @include('partials.home.login_modal');
    @include('partials.home.register_modal');
@endsection

@push('scripts')
    <script src="{{ asset('js/home/index.js') }}"></script>
@endpush
