@extends('layouts.master')

@section('title', 'Dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/header.css') }}">
@endpush

@section('header')
    @include('partials.dashboard.header')
@endsection

@section('sidebar')
    @include('partials.dashboard.sidebar')
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-6">
                <h4>Orders Data</h4>
                <canvas id="ordersChart"></canvas>
            </div>
            <div class="col-6">
                <h4>Users Data</h4>
                <canvas id="usersChart"></canvas>
            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="card mt-5">
                        <div class="card-header">
                            <h4>Active Users</h4>
                        </div>
                        <div class="card-body">
                            <div>
                                <p id="activeUserCount">{{ $activeUsersCount }}</p>
                                <button id="refresh_button" class="btn btn-primary">
                                    <i class="fas fa-sync-alt"></i> Refresh
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.dashboard.footer')
@endsection

@section('modals')
    @include('partials.dashboard.login_modal')
@endsection

@push('scripts')
    <script src="{{ asset('js/dashboard/index.js') }}"></script>
@endpush

<script>

</script>
