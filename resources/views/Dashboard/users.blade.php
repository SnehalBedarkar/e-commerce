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
    <div class="container mt-4">
        <h1>Users List</h1>
        <table class="table table-striped" id="users_table">
            <thead class="thead-dark">
                <tr>
                    <th><input type="checkbox" id="select_all"></th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Phone Number</th>
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
                           <button type="button" class="btn btn-sm btn-danger remove-btn" data-bs-target="#deleteModal" data-bs-toggle="modal" data-user-id="{{ $user->id }}">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <button type="button" id="multipleDeleteBtn" data-bs-target="multipleDelete" data-bs-toggle="modal" class="btn btn-danger btn-sm">Delete</button>
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