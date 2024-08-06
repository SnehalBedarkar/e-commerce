@extends('layouts.master')

@section('title','Categories')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/home/categories.css') }}">
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
        <div class="col-12">
            <h2>Categories for You</h2>
            <div class="categories">
                @foreach($categories as $category)
                    <div class="category-card">
                        <h3>{{ $category->name }}</h3>
                        <div class="category-products">
                            @foreach($category->products->take(1) as $product) <!-- Display a few sample products -->
                                <div class="product-card">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                    <a href="#" class="btn-secondary">View Details</a>
                                </div>
                            @endforeach
                        </div>
                        <a href="#" class="btn-primary">View All</a>
                    </div>
                @endforeach
            </div>
        </div>
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
    <script src="{{ asset('js/home/categories.js') }}"></script>
@endpush