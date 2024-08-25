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
    <div id="home_container">
        <h3 class="text-center">Welcome To the ClayWork</h3>

        <!-- Search Bar -->
        <div class="row justify-content-center">
            <div class="col-10 mb-4">
                <input type="search" id="searchQuery" name="query" class="form-control mb-2" placeholder="Search Products">
            </div>
        </div>

        <!-- Categories Section -->
        <div class="row">
            @foreach($categories as $category)
            <div class="col-2 mb-3 text-center">
                <nav aria-label="Category navigation">
                    <ul class="list-unstyled">
                        <li>
                            <a href="{{ route('category.products', $category->id) }}">
                                <img src="{{ asset('storage/'.$category->image) }}" alt="{{ $category->name }}" class="category-img">
                            </a>
                        </li>
                        <li class="mt-2">{{ $category->name }}</li>
                    </ul>
                </nav>
            </div>
            @endforeach
        </div>

        <!-- Products Section -->
        <h5>Our Some Most Visited Products</h5>
        <div class="row">
            @foreach ($categories as $category)
                <div class="col-12 mb-4">
                    <h6>{{ $category->name }}</h6>
                    <div class="row">
                        @foreach ($category->products as $product)
                        <div class="col-3 mb-4">
                            <a href="{{ route('category.products', $category->id) }}" class="text-decoration-none">
                                <div class="card text-center" data-id="{{ $product->id }}">
                                    @if($product->image && Storage::exists('public/' . $product->image))
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="card-img-top">
                                    @else
                                        <img src="{{ asset('images/default-product.jpg') }}" alt="Default Image" class="card-img-top">
                                    @endif
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $product->name }}</h6>
                                        <p class="card-text">Rs {{ $product->price }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection

@section('footer')
    @include('partials.home.footer')
@endsection

@section('modals')
    @include('partials.home.login_modal')
    @include('partials.home.register_modal')
@endsection

@push('scripts')
    <script src="{{ asset('js/home/index.js') }}"></script>
@endpush
