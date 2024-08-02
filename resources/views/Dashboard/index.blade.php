@extends('layouts.master')

@section('title', 'Dashboard')

@section('header')
    @include('partials.dashboard.header')
@endsection

@section('sidebar')
    @include('partials.dashboard.sidebar')
@endsection

@section('content')
    <h1>Dashboard</h1>
    <p>This is the content of the dashboard.</p>
@endsection

@section('footer')
    @include('partials.dashboard.footer')
@endsection

@push('scripts')
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endpush
