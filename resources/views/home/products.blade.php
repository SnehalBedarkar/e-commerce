<!-- resources/views/home.blade.php -->

@extends('layouts.master')

@section('title', 'Products')

@push('styles')
   <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('header')
    @include('partials.home.header')
@endsection

@section('sidebar')
    @include('partials.home.sidebar')
@endsection

@section('content')
    <div class="container">
        <div class="main-section">
            <h1>Products</h1>
            @if($products->isEmpty())
                <p>No products available.</p>
            @else
                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-md-4">
                            <div class="card mb-4 shadow-sm">
                                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="width: 100px; height: auto;">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">Price: Rs {{ $product->price }}</p>
                                    <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                                    <div class="d-flex justify-content-between mt-3">
                                        <button type="button" class="btn btn-primary btn-sm add-to-cart" data-user-id="{{ Auth::id() }}" data-id="{{ $product->id }}">Add to Cart</button>
                                        <button type="button" class="btn btn-primary btn-sm buy_now" data-user-id="{{ Auth::id() }}" data-id="{{ $product->id }}">Buy Now</button>
                                    </div>
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
    <script src="{{ asset('js/home.js') }}"></script>
@endpush

