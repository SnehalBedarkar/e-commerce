@extends('layouts.master')

@section('title', 'Products')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard/products.css') }}">
@endpush

@section('header')
    @include('partials.dashboard.header')
@endsection

@section('sidebar')
    @include('partials.dashboard.sidebar')
@endsection

@section('content')
    <div class="container-sm mt-4">
        <div class="row">
            <div class="col-12 text-center">
                <h5>Products List</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-2">
                        <select name="" id="" class="form-select">
                            @foreach ($categories as $category )
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2">
                        <select name="" id="" class="form-select">
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row align-items-end">
            <div class="col-12 mb-2">
                <button type="button" class="btn btn-danger" id="multipleProductsDelete">Delete</button>
            </div>
        </div>
        <div class="row align-items-end"> <!-- Align items to the bottom for better spacing -->
            <div class="col-6 mb-3">
                <input type="search" name="searchQuery" id="searchQuery" class="form-control" placeholder="Search...">
            </div>
            <div class="col-4 mb-3">
                <div class="row g-2"> <!-- g-2 for gap between date inputs -->
                    <div class="col-6">
                        <input type="date" name="start_date" id="start_date" class="form-control">
                    </div>
                    <div class="col-6">
                        <input type="date" name="end_date" id="end_date" class="form-control">
                    </div>
                </div>
            </div>
            <div class="col-2 mb-3">
                <div class="d-flex gap-2 justify-content-end"> <!-- Space between buttons and align to the right -->
                    <button type="button" id="search_button" class="btn btn-primary btn-sm">
                        <i class="bi bi-search"></i> Search
                    </button>
                    <button type="button" id="create_product" class="btn btn-primary btn-sm" data-bs-target="#createProductModal" data-bs-toggle="modal">
                        <i class="fas fa-plus-circle"></i> Create Product
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 table-responsive">
                <table class="table table-striped table-bordered" id="products_table">
                    <thead>
                        <tr>
                            <th> <input type="checkbox" id="select-all">Check</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Sale Price</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>View Count</th>
                            <th>Rating</th>
                            <th>Review Count</th>
                            <th>Featured</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        @forelse ($products as $product)
                            <tr data-id="{{ $product->id }}">
                                <td><input type="checkbox" class="select-checkbox" data-id="{{ $product->id }}"></td>
                                <td class="product_id">{{ $product->id }}</td>
                                <td class="product_name">{{ $product->name }}</td>
                                <td class="product_image"><img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="30px" class="img-fluid"></td>
                                <td>{{ $product->sale_price }}</td>
                                <td class="product_price">Rs {{ number_format($product->price, 2) }}</td>
                                <td>{{ $product->status }}</td>
                                <td>{{ $product->view_count }}</td>
                                <td>{{ $product->rating }}</td>
                                <td>{{ $product->review_count }}</td>
                                <td>{{ $product->featured }}</td>
                                <td>
                                    <!-- Example action buttons, e.g., edit and delete -->
                                    <button type="button" class="btn btn-primary btn-sm view-btn" data-bs-target="#viewProductModal" data-bs-toggle="modal"> <i class="bi bi-eye"></i></button>
                                    <button type="button" class="btn btn-secondary btn-sm edit-btn" data-bs-toggle="modal" data-bs-target="#editProductModal"> <i class="bi bi-pencil"></i></button>
                                    <button type="button" class="btn btn-danger btn-sm remove-btn" data-bs-toggle="modal"  data-bs-target="#productDeleteModal">  <i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr id="tbl_msg">
                                <td colspan="6">No products found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.dashboard.footer')
@endsection

@section('modals')
    @include('partials.dashboard.add_modal')
    @include('partials.dashboard.delete_modal')
    @include('partials.dashboard.edit_modal')
    @include('partials.dashboard.view_modal')
@endsection

@push('scripts')
    <script src="{{ asset('js/dashboard/products.js') }}"></script>
@endpush
