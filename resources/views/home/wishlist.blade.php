@extends('layouts.master')

@section('title', 'Wishlist')

@push('styles')
   <link rel="stylesheet" href="{{ asset('css/home/wishlist.css') }}">
@endpush

@section('header')
    @include('partials.home.header')
@endsection

@section('sidebar')
    @include('partials.home.sidebar')
@endsection

@section('content')
    <h1>Your Wishlist</h1>
    <!-- Display wishlist items here -->
    <ul>
        <!-- Example wishlist item -->
        <li>Item 1 - Price: $20.00</li>
    </ul>
@endsection

@section('footer')
    @include('partials.home.footer')
@endsection

@push('scripts')
    <script src="{{ asset('js/home/wishlist.js') }}"></script>
@endpush
