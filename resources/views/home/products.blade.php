@extends('layouts.master')

@section('title', 'Products')

@push('styles')
   <link rel="stylesheet" href="{{ asset('css/home/products.css') }}">
@endpush

@section('header')
    @include('partials.home.header')
@endsection

@section('sidebar')
    @include('partials.home.sidebar')
@endsection

@section('content')
    <div class="container pt-5">
        <div class="main-section">
            <h1>Products</h1>
            @if($products->isEmpty())
                <p>No products available.</p>
            @else
                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-md-4">
                            <div class="card mb-4 shadow-sm" data-id="{{ $product->id }}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="width: 100px; height: auto;">
                                        </div>
                                        <div class="col-md-6">
                                            <h5 class="card-title">{{ $product->name }}</h5>
                                            <p class="card-text">Price: Rs {{ $product->price }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between p-3">
                                    <button type="button" class="btn btn-primary btn-sm add-to-cart " data-user-id="{{ Auth::id() }}" data-id="{{ $product->id }}">Add to Cart</button>
                                    <a class="btn btn-primary btn-sm buy-now" data-user-id="{{ Auth::id() }}" data-id="{{ $product->id }}">Buy Now</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.home.footer')
@endsection

@section('modals')
    @include('partials.home.login_modal');
    @include('partials.home.register_modal');
@endsection

@push('scripts')
    <script src="{{ asset('js/home/products.js') }}"></script>
@endpush

