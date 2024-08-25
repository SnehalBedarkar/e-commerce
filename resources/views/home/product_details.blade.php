@extends('layouts.master')

@section('title', $product->name)

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/home/product_details.css') }}">
@endpush

@section('header')
    @include('partials.home.header')
@endsection

@section('sidebar')
    @include('partials.home.sidebar')
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <ul class="list-unstyled">
                            <li>
                                <img src="{{ asset('storage/'.$product->image) }}" alt="Product Image" width="80px">
                            </li>
                            <li>
                                <img src="{{ asset('storage/'.$product->image) }}" alt="Product Image" width="80px">
                            </li>
                            <li>
                                <img src="{{ asset('storage/'.$product->image) }}" alt="" width="80px">
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-8">
                        <div class="card mt-2">
                            <div class="position-relative">
                                <div class="product-image-container">
                                    <img id="product-image" src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="card-img-top mb-2">
                                    <div id="zoom-lens"></div>
                                    <div id="zoom-result"></div>
                                    <button class="btn btn-light position-absolute top-0 end-0 m-2 wishlist-button" data-id="{{ $product->id }}">
                                        <i class="fas fa-heart wishlist-icon"></i> <!-- FontAwesome heart icon -->
                                    </button>
                                </div>
                            </div>
                            <div class="card-body d-flex justify-content-between">
                                <button class="btn btn-secondary" id="add-to-cart" data-id="{{ $product->id }}">Add To Cart</button>
                                <button class="btn btn-primary" id="buy-now" data-id="{{ $product->id }}">Buy Now</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <h5>{{ $product->name }}</h5>
                <h4>Rs {{ $product->price }}</h4>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.home.footer')
@endsection

@push('scripts')
    <script src="{{ asset('js/home/product_details.js') }}"></script>
@endpush
