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
        <div class="row">
            <div class="col-2">
                <div class="card">
                    <div class="card-header">
                        <h4>Filters</h4>
                    </div>
                    <div class="card-body">
                        @foreach ($brands as $brand)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="brand-{{ $brand->id }}" name="brands[]" value="{{ $brand->id}}">
                            <label class="form-check-label" for="brand-{{ $brand->id }}">
                                {{ $brand->name }}
                            </label>
                        </div>
                    @endforeach
                    </div>
                </div>

            </div>
            <div class=" col-10 main-section">
                <div class="mb-3">
                    <h5 class="fw-bold">{{ $category->name }}</h5>
                </div>
                @if($products->isEmpty())
                    <p class="text-muted">No products available.</p>
                @else
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex align-items-center mb-3">
                                <span class="mr-3">Sort By:</span>
                                <div class="btn-group" role="group" aria-label="Sort Options">
                                    <button type="button" class="btn btn-secondary low-to-high" data-id="{{ $category->id }}" data-action="low_to_high">Price--Low to High</button>
                                    <button type="button" class="btn btn-secondary high-to-low" data-id="{{ $category->id }}" data-action="high_to_low">Price--High to Low</button>
                                    {{-- <button type="button" class="btn btn-secondary popularity" data-id="{{ $category->id }}" data-action="popularity">Popularity</button> --}}
                                    <button type="button" class="btn btn-secondary newest" data-id="{{ $category->id }}" data-action="newest">Newest First</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2 border" id="product_list">
                        @foreach ($products as $product)
                            <div class="col-md-12 mb-4 ms-auto">
                                <a href="{{ route('product.details',$product->id) }}" class="text-decoration-none">
                                    <div class="card  shadow-sm border-0" data-id="{{ $product->id }}">
                                        <div class="row justify-content-around">
                                            <div class="col-2 m-0 align-self-center position-relative ">
                                                <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid img-thumbnail rounded-start mb-2 mt-2" alt="{{ $product->name }}" style="width: 100px; height: auto;">
                                                <button class="btn btn-light position-absolute top-0 end-0 m-2 wishlist-button" data-id="{{ $product->id }}">
                                                    <i class="fas fa-heart wishlist-icon"></i> <!-- FontAwesome heart icon -->
                                                </button>
                                            </div>
                                            <div class="col-6 align-self-auto">
                                                <h5 class="card-title mb-0">{{ $product->name }}</h5>
                                            </div>
                                            <div class="col-2 align-self-auto" >
                                                <p class="card-text mb-0"><strong> Rs {{ $product->price }}</strong></p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
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
    @include('partials.home.alert_modal')
@endsection

@push('scripts')
    <script src="{{ asset('js/home/products.js') }}"></script>
@endpush
