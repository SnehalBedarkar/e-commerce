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
    <div class="container-fluid">
        <!-- Dashboard Charts -->
        <div class="row mb-4 mt-2">
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header">
                        <h4 class="card-title">Orders Data</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="ordersChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header">
                        <h4 class="card-title">Users Data</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="usersChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="row">
                    <div class="col-lg-6 col-md-6 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-header">
                                <h4 class="card-title">Active Users</h4>
                            </div>
                            <div class="card-body">
                                <p id="activeUserCount" class="display-4">{{ $activeUsersCount }}</p>
                                <button id="refresh_button" class="btn btn-primary">
                                    <i class="fas fa-sync-alt"></i> Refresh
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 mb-4">
                        <div class="card text-white bg-success shadow-sm h-100">
                            <div class="card-header">
                                <h4 class="card-title">Total Revenue</h4>
                            </div>
                            <div class="card-body">
                                <h2>Rs {{ $totalRevenue }}</h2> <!-- Example value -->
                            </div>
                        </div>
                    </div>
                    <!-- Additional Cards/Sections if needed -->
                    <div class="col-lg-6 col-md-6 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-header">
                                <h4 class="card-title">Other Stats</h4>
                            </div>
                            <div class="card-body">
                                <!-- Content Here -->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-header">
                                <h4 class="card-title">Other Stats</h4>
                            </div>
                            <div class="card-body">
                                <!-- Content Here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Total Income</h5>
                        <p>Year Report Overview</p>
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
