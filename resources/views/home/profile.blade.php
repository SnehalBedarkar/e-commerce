@extends('layouts.master')

@section('title','Profile')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/home/profile.css') }}">
@endpush

@section('header')
    @include('partials.home.header')
@endsection

@section('sidebar')
    @include('partials.home.sidebar')
@endsection

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-start">
                        {{-- <img src="{{ $user->avatar ?? 'default-avatar.png' }}" class="img-fluid rounded-circle mb-3" alt="User Avatar"> --}}
                        <span>Hello</span><h4>{{ explode(' ', Auth::user()->name)[0] }} </h4>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header">
                        <button class="btn btn-secondary">My Orders</button>
                    </div>
                    <div class="card-body">
                        <h5>Account Setting</h5>
                        <a class="btn btn-outline-primary mb-2">Profile Information</a>
                        <a id="adderess_manage" class="btn btn-outline-primary mb-2">Manage Addresses</a>
                        <div>
                            <button class="btn btn-danger ">Logout</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9" id="main-content">
                <div class="card">
                    <div class="card-header">
                        <h5>Profile Information</h5>
                    </div>
                    <div class="card-body">
                        <form id="profile_update_form">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" readonly>
                            </div>
                        </form>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary btn-sm mt-4">Update Profile</button>

                {{-- <div class="card mt-4">
                    <div class="card-header">
                        <h5>My Orders</h5>
                    </div>
                    <div class="card-body">
                        @if($user->orders->isEmpty())
                            <p>You have no orders yet.</p>
                        @else
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Order Number</th>
                                        <th>Date</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->orders as $order)
                                        <tr>
                                            <td>{{ $order->order_number }}</td>
                                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                            <td>${{ $order->total }}</td>
                                            <td>{{ $order->status }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div> --}}

                {{-- <div class="card mt-4">
                    <div class="card-header">
                        <h5>Wishlist</h5>
                    </div>
                    <div class="card-body">
                        @if($user->wishlist->isEmpty())
                            <p>Your wishlist is empty.</p>
                        @else
                            <ul class="list-group">
                                @foreach($user->wishlist as $item)
                                    <li class="list-group-item">{{ $item->name }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.home.footer')
@endsection

@push('scripts')
    <script src="{{ asset('js/home/profile.js') }}"></script>
@endpush