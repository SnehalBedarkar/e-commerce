@extends('layouts.master')

@section('title', 'Forgot Password')
{{-- 
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/custom-styles.css') }}">
@endpush --}}

@section('header')
    @include('partials.home.header')
@endsection

@section('content') 
    <div class="container mt-5 mb-5 h-70vh ">
        <div class="row d-flex align-items-center justify-content-center h-75 w-100">
            <div class="col-6">
                <!-- Replace 'path/to/your/image.jpg' with the actual path to your image -->
                {{-- <img src="{{ asset('storage/forgot_password_image.jpg') }}" alt="Description of the image" class="img-fluid"> --}}
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Forgot Password</h4>
                    </div>
                    <div class="card-body">
                        <form id="password_reset_form">
                            <p>Enter Your Email</p>
                            <div class="row">
                                <div class="col-6">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="email">
                                    <button type="submit" id="send_otp" class="btn btn-primary mt-1">Send OTP</button>
                                </div>
                                <div class="col-6 ">
                                    <input type="string" id="otp" class="form-control" name="otp" placeholder="OTP">
                                    <button type="submit" id="submit_otp" class="btn btn-primary mt-1 " >Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.home.footer')
@endsection

@push('scripts')
    <script src="{{ asset('js/home/forgot_password.js') }}"></script>
@endpush
