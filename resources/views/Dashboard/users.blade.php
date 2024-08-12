@extends('layouts.master')

@section('title', 'Users')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard/users.css') }}">
@endpush

@section('header')
    @include('partials.dashboard.header')
@endsection

@section('sidebar')
    @include('partials.dashboard.sidebar')
@endsection

@section('content')
    <div class="alert-container mt-4">
        <h4>Users List</h4>

        <!-- Search Filter -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="searchQuery" class="form-label">Search</label>
                <input type="search" id="searchQuery" class="form-control" placeholder="Search users">
            </div>
            <div class="col-md-6 mb-3">
                <div class="row">
                    <div class="col-5 mb-2">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" id="start_date" value="" class="form-control date">
                    </div>
                    <div class="col-5 mb-2">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" id="end_date" value="" class="form-control date">
                    </div>
                    <div class="col-2">
                        <button id="search_button" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row table-responsive">
            <div class="col-12">
                <table class="table table-striped table-bordered table-hover table-dark table-sm" id="users_table">
                    <thead class="thead-dark">
                        <tr>
                            <th><input type="checkbox" id="select_all"> Check</th>
                            <th>
                                <div class="button-container">
                                    <span>ID</span>
                                    <button  id="upward_id">^</button>
                                    <button  id="downward_id">v</button>
                                </div>
                            </th>
                            <th>
                                <div class="button-container">
                                    <span>Name</span>
                                    <button  id="upword_name">^</button>
                                    <button id="downward_name">v</button>
                                </div>
                            </th>
                            <th>
                                <div class="button-container">
                                    <span>Status</span>
                                    <button id="upword">^</button>
                                    <button id="downward">v</button>
                                </div>
                            </th>
                            <th>
                                <div class="button-container">
                                    <span>Email</span>
                                    <button id="upword">^</button>
                                    <button id="downward">v</button>
                                </div>
                            </th>
                            <th>
                                <div class="button-container">
                                    <span>Role</span>
                                    <button id="upword">^</button>
                                    <button id="downward">v</button>
                                </div>
                            </th>
                            <th>
                                <div class="button-container">
                                    <span>Phone Number</span>
                                    <button id="upword">^</button>
                                    <button id="downward">v</button>
                                </div>
                            </th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr data-id="{{ $user->id }}">
                                <td><input type="checkbox" class="select-checkbox" data-id="{{ $user->id }}"></td>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->is_active }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                                <td>{{ $user->phone_number }}</td>
                                <td>
                                   <button type="button" class="btn btn-sm btn-danger remove-btn" data-bs-target="#userDeleteModal" data-bs-toggle="modal" data-user-id="{{ $user->id }}">Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">No users found.</td>
                            </tr>
                        @endforelse
                        <button type="button" id="#multipleDeleteBtn" data-bs-target="#multipleUsersDeleteModal" data-bs-toggle="modal" class="btn btn-danger btn-sm mb-2">Delete</button>
                    </tbody>
                </table>
            </div>
        </div>
@endsection

@section('footer')
    @include('partials.dashboard.footer')
@endsection

@section('modals')
    @include('partials.dashboard.delete_modal')
@endsection


@push('scripts')
    <script src="{{ asset('js/dashboard/users.js') }}"></script>
@endpush