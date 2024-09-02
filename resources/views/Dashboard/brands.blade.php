@extends('layouts.master')

@section('title','Brands')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard/brands.css') }}">
@endpush

@section('header')
    @include('partials.dashboard.header')
@endsection

@section('sidebar')
    @include('partials.dashboard.sidebar')
@endsection

@section('content')
    <div class="container">
        <div class="row mt-2">
            <div class="col-12 text-center">
                <h5>Brands</h5>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-2">
                <select name="category_id" id="category_id" class="form-select">
                    @foreach ($categories as $category )
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6">
                <input type="search" class="form-control" id="search-query" name="search-query" placeholder="Search Brands">
            </div>
            <div class="col-4 text-end">
                <button type="button" class="btn btn-primary mb-2 mt-2" id="create-brand" data-bs-target="#createBrandModal" data-bs-toggle="modal">
                    <i class="fas fa-plus-circle"></i>
                </button>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-bordered" >
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Logo</th>
                                <th>Website</th>
                                <th>Is Active</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($brands as $brand )
                            <tr>
                                <td>{{ $brand->id }}</td>
                                <td>{{ $brand->name}}</td>
                                <td>{{ $brand->slug }}</td>
                                <td>
                                    <img src="{{ asset('storage/'.$brand->logo) }}" alt="{{ $brand->name }}" class="img-fluid img-thumbnail" width="50px" >
                                </td>
                                <td>{{ $brand->website }}</td>
                                <td>{{ $brand->is_active }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm view-btn" data-bs-target="#viewBrandModal" data-bs-toggle="modal"> <i class="bi bi-eye"></i></button>
                                    <button type="button" class="btn btn-secondary btn-sm edit-btn" data-bs-target="#editBrandModal" data-bs-toggle="modal"> <i class="bi bi-pencil"></i></button>
                                    <button type="button" class="btn btn-danger btn-sm remove-btn" data-bs-target="#deleteBrandModal" data-bs-toggle="modal">  <i class="bi bi-trash"></i></button>
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
    @include('partials.dashboard.view_modal')
@endsection

@push('scripts')
    <script src="{{ asset('js/dashboard/brands.js') }}"></script>
@endpush
