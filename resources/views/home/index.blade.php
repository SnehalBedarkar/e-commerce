
@extends('layouts.master')

@section('title', 'Home')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('header')
    @include('partials.home.header')
@endsection

@section('sidebar')
    @include('partials.home.sidebar')
@endsection

@section('content')
    <div ></div>
    <h1>Welcome to the Home Page</h1>
    <p>This is the content of the home page.</p>
@endsection

@section('footer')
    @include('partials.home.footer')
@endsection

@section('modals')
    @include('partials.home.login_modal');
    @include('partials.home.register_modal');
@endsection

@push('scripts')
    <script src="{{ asset('js/home.js') }}"></script>
@endpush
