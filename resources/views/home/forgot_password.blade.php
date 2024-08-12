@extends('layouts.master')

@section('title', 'Forgot Password')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/home/forgot_password.css') }}">
@endpush

@section('header')
    @include('partials.home.header')
@endsection

@section('content') 
    <div class="container mt-5 mb-5 ">
        <div class="row">
            <div class="col-4">
                <!-- Replace 'path/to/your/image.jpg' with the actual path to your image -->
                {{-- <img src="{{ asset('storage/forgot_password_image.jpg') }}" alt="Description of the image" class="img-fluid"> --}}
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Forgot Password</h4>
                    </div>
                    <div class="card-body">
                        <form id="password_reset_form">
                            <p>Enter Your Email</p>
                            <div class="row">
                                <div class="col-6">
                                    <div>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="email">
                                        <span id="email_error"></span>
                                    </div>
                                    <button type="submit" id="send_otp" class="btn btn-primary mt-2">Send OTP</button>
                                </div>
                                <div class="col-6 ">
                                    <div>
                                        <input type="string" id="otp" class="form-control mb-2" name="otp" placeholder="OTP">
                                        <span id="otp_error"></span>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="time-display">
                                                <span id="minutes" class="time-part">00</span>:
                                                <span id="seconds" class="time-part">00</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <button type="submit" id="submit_otp" class="btn btn-primary mt-2 border">Submit</button>
                                        </div>
                                    </div>
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
