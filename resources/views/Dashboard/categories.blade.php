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
            <div class="col-12">
                <h4 class="text-center">Categories List</h4>
                <div class="mb-2 text-end">
                    <button type="button" class="btn btn-primary " id="create_category" data-bs-target="createCategoryModal" data-bs-toggle="modal">Create Category</button>
                </div>
                <table class="table table-bordered" id="categories_table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        @foreach ($categories as $category)
                            <tr data-id="{{ $category->id }}">
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->slug }}</td>
                                <td class="category_description">{{ $category->description }}</td>
                                <td class="category_image"><img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category   ->name }}" width="50px"></td>
                                <td>
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
