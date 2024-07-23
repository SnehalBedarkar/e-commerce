@extends('Dashboard.layouts.master')
@section('title','Users')
@section('content')
    <div class="main-content col-md-10 ms-sm-auto">
        <h2 class="mb-4">Users List</h2>
        @if ($users->count() > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone_number }}</td>
                            <td>
                                <a href="{{ route('user.show', $user->id) }}" class="btn btn-primary btn-sm">View</a>
                                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                                <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No users found.</p>
        @endif
    </div>
    </div>
    </div>
@endsection