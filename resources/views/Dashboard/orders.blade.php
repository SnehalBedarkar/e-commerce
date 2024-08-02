@extends('layouts.master')

@section('title', 'Orders')

@section('header')
    @include('partials.dashboard.header')
@endsection

@section('sidebar')
    @include('partials.dashboard.sidebar')
@endsection

@section('content')
    <h1>Orders</h1>
    <p>This is the content for the orders section.</p>
@endsection

@section('footer')
    @include('partials.dashboard.footer')
@endsection

@push('scripts')
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endpush