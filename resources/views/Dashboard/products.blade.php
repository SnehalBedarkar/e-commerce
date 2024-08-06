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
        <h1>Products List</h1>
        <button type="button" class="btn btn-primary" id="create_product" data-bs-target="#createProductModal" data-bs-toggle="modal">Add Product</button>
        <table class="table table-striped" id="products_table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr data-id="{{ $product->id }}">
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>Rs{{ number_format($product->price, 2) }}</td>
                        <td>
                            <!-- Example action buttons, e.g., edit and delete -->
                            <button type="button" class="btn btn-primary btn-sm" data-bs-target="#viewModal" data-bs-toggle="modal">View</button>
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#EditModal">Edit</button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal"> Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
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
    @include('partials.dashboard.add_product')
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