@extends('layouts.master')

@section('title', 'Assign Roles')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard/assign_roles.css') }}">
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
                <h5>Assign Roles to Users</h5>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6 mb-3">
                <label for="searchUserQuery" class="form-label">Search Users</label>
                <input type="search" id="searchUserQuery" class="form-control" placeholder="Search users">
            </div>
            <div class="col-md-4 mb-3">
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" id="start_date" value="" class="form-control">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" id="end_date" value="" class="form-control">
                    </div>
                </div>
            </div>
            <div class="col-2">
                <button type="button" class="btn btn-primary" id="add-position" data-bs-target="#registerModal" data-bs-toggle="modal">Add Position</button>
            </div>
        </div>

        <div class="row table-responsive">
            <div class="col-12">
                <table class="table table-bordered" id="users_table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select_all_users"> Check</th>
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
                            <th>Assigned Roles</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr data-id="{{ $user->id }}">
                                <td><input type="checkbox" class="select-checkbox" data-id="{{ $user->id }}"></td>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td class="roles-column">{{ $user->roles->pluck('name')->join(', ') }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm view-btn" data-bs-toggle="modal" data-bs-target="#roleViewModal" > <i class="bi bi-eye"></i></button>
                                    <button type="button" class="btn btn-secondary btn-sm edit-btn" data-bs-toggle="modal" data-bs-target="#roleEditModal"> <i class="bi bi-pencil"></i></button>
                                    <button type="button" class="btn btn-danger btn-sm remove-btn" data-bs-toggle="modal"  data-bs-target="#roleDeleteModal">  <i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">No users found.</td>
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
    @include('partials.dashboard.register_modal')
@endsection



@push('scripts')
    <script src="{{ asset('js/dashboard/assign_roles.js') }}"></script>
@endpush
