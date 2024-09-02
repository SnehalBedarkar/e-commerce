@extends('layouts.master')

@section('title', '403 Forbidden')

@section('content')
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card text-center shadow p-4" style="width: 100%; max-width: 400px;">
            <div class="card-body">
                <h1 class="card-title text-danger">403 Forbidden</h1>
                <p class="card-text">You do not have permission to access this page.</p>
                <a href="{{ url('/') }}" class="btn btn-primary">Return to Home</a>
            </div>
        </div>
    </div>
@endsection
