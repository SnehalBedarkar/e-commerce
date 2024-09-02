@extends('layouts.master')

@section('title','Categories')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard/categories.css') }}">
@endpush

@section('header')
    @include('partials.dashboard.header')
@endsection

@section('sidebar')
    @include('partials.dashboard.sidebar')
@endsection

@section('content')
    <div id="container">
        <div class="row">
            <div class="col-12 text-center`">
                <h5>Categories List</h5>
            </div>
        <div class="row">
            <div class="col-12">
                <div class="mb-2 text-end">
                    <button type="button" class="btn btn-primary" id="create_category" data-bs-target="createCategoryModal" data-bs-toggle="modal">Create Category</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-bordered" id="categories_table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th class="description-column">Description</th>
                                <th>Image</th>
                                <th class="actions-column">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            @foreach ($categories as $category)
                                <tr data-id="{{ $category->id }}">
                                    <td id="category_id">{{ $category->id }}</td>
                                    <td id="category_name">{{ $category->name }}</td>
                                    <td id="category_slug">{{ $category->slug }}</td>
                                    <td id="category_description" class="category_description description-column">{{ $category->description }}</td>
                                    <td id="category_image" class="category_image"><img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" width="50px"></td>
                                    <td class="actions-column">
                                        <button class="btn btn-primary btn-sm view-btn" data-bs-target="#viewCategoryModal" data-bs-toggle="modal">View</button>
                                        <button class="btn btn-secondary btn-sm edit-btn" data-bs-target="#editCategoryModal" data-bs-toggle="modal">Edit</button>
                                        <button class="btn btn-danger btn-sm delete-btn" data-bs-target="#categoryDeleteModal" data-bs-toggle="modal">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
    <script src="{{ asset('js/dashboard/categories.js') }}"></script>
@endpush
