@extends('layouts.master')

@section('title', 'Roles')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard/roles.css') }}">
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
            <div class="col-12 mt-1 text-center">
                <h5>Roles List</h5>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-5 mb-3">
                <label for="searchQuery" class="form-label">Search</label>
                <input type="search" id="searchQuery" class="form-control" placeholder="Search roles">
            </div>
            <div class="col-md-7 mb-3">
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" id="start_date" value="" class="form-control">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" id="end_date" value="" class="form-control">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button id="search_button" class="btn btn-primary me-2">Search</button>
                        <button type="button" class="btn btn-primary" data-bs-target="#roleCreateModal" data-bs-toggle="modal">Add Role</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="row table-responsive">
            <div class="col-12">
                <table class="table table-bordered" id="roles_table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select_all"> Check</th>
                            <th>
                                ID
                                <i class="fas fa-arrow-up sort" data-column="id" data-action="asc" style="cursor: pointer;"></i>
                                <i class="fas fa-arrow-down sort" data-column="id" data-action="desc" style="cursor: pointer;"></i>
                            </th>
                            <th>
                                Name
                                <i class="fas fa-arrow-up sort" data-column="name" data-action="asc" style="cursor: pointer;"></i>
                                <i class="fas fa-arrow-down sort" data-column="name" data-action="desc" style="cursor: pointer;"></i>
                            </th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roles as $role)
                            <tr data-id="{{ $role->id }}">
                                <td><input type="checkbox" class="select-checkbox" data-id="{{ $role->id }}"></td>
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td class="description-column">{{ $role->description }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm view-btn" data-bs-toggle="modal" data-bs-target="#roleViewModal" > <i class="bi bi-eye"></i></button>
                                    <button type="button" class="btn btn-secondary btn-sm edit-btn" data-bs-toggle="modal" data-bs-target="#roleEditModal"> <i class="bi bi-pencil"></i></button>
                                    <button type="button" class="btn btn-danger btn-sm remove-btn" data-bs-toggle="modal"  data-bs-target="#roleDeleteModal">  <i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">No roles found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
            <button type="button" id="multipleDeleteBtn" data-bs-target="#multipleRolesDeleteModal" data-bs-toggle="modal" class="btn btn-danger btn-sm mb-2">Delete</button>
        </div>
@endsection

@section('footer')
    @include('partials.dashboard.footer')
@endsection

@section('modals')
    @include('partials.dashboard.roles.role_add_modal')
    @include('partials.dashboard.delete_modal')
@endsection

@push('scripts')
    <script src="{{ asset('js/dashboard/roles.js') }}"></script>
@endpush
