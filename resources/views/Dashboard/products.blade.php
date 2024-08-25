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
    <div class="container mt-4">
        <div class="row">
            <h1>Products List</h1>
        </div>
        <div class="row align-items-end">
            <div class="col-2 mb-2">
                <button type="button" class="btn btn-danger" id="multipleProductsDelete">Delete</button>
            </div>
            <div class="col-2 ms-auto">
                <button type="button" class="btn btn-primary mb-2" id="create_product" data-bs-target="#createProductModal" data-bs-toggle="modal">Add Product</button>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <input type="search" name="searchQuery" id="searchQuery" class="form-control mb-2 ">
            </div>
            <div class="col-4">
                <div class="row">
                    <div class="col-6">
                        <input type="date" name="start_date" id="start_date" class="form-control mb-2">
                    </div>
                    <div class="col-6">
                        <input type="date" name="end_date" id="end_date" class="form-control mb-2">
                    </div>
                </div>
            </div>
            <div class="col-2">
                <button type="button" id="search_button" class="btn btn-primary">Search</button>
            </div>
        </div>
        <table class="table table-striped" id="products_table">
            <thead>
                <tr>
                    <th> <input type="checkbox" id="select-all">Check</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="tbody">
                @forelse ($products as $product)
                    <tr data-id="{{ $product->id }}">
                        <td><input type="checkbox" class="select-checkbox" data-id="{{ $product->id }}"></td>
                        <td class="product_id">{{ $product->id }}</td>
                        <td class="product_name">{{ $product->name }}</td>
                        <td class="product_image"><img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="30px"></td>
                        <td class="product_description">{{ $product->description }}</td>
                        <td class="product_price">Rs {{ number_format($product->price, 2) }}</td>
                        <td>
                            <!-- Example action buttons, e.g., edit and delete -->
                            <button type="button" class="btn btn-primary btn-sm view-btn" data-bs-target="#viewProductModal" data-bs-toggle="modal">View</button>
                            <button type="button" class="btn btn-secondary btn-sm edit-btn" data-bs-toggle="modal" data-bs-target="#editProductModal">Edit</button>
                            <button type="button" class="btn btn-danger btn-sm remove-btn" data-bs-toggle="modal"  data-bs-target="#productDeleteModal"> Delete</button>
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