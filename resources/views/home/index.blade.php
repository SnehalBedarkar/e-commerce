@extends('layouts.master')

@section('title', 'Home')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/home/index.css')}}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css')}}">
@endpush

@section('header')
    @include('partials.home.header')
@endsection

@section('sidebar')
    @include('partials.home.sidebar')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center" style="height: 100vh;">
            <div class="col-12 text-center">
                <h3>Welcome To the ClayWork</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-12">

            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.home.footer')
@endsection

@section('modals')
    @include('partials.home.login_modal');
    @include('partials.home.register_modal');
@endsection

@push('scripts')
    <script src="{{ asset('js/home/index.js') }}"></script>
@endpush
