@extends('layouts.master')  

@section('title','Password Reset')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/home/password_reset.css') }}">
@endpush

@section('header')
    @include('partials.home.header')
@endsection

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Set New Password 
                </div>
                <div class="card-body">
                    <form id="password_reset_form">
                        <div class="form-group">
                            <label for="username" class="form-label mb-2">Username or Email</label>
                            <div class="input-group">
                                <input id="email" type="text" class="form-control mb-2" name="email"  autocomplete="username">
                            </div>
                            <div class="invalid-feedback" id="email_error">
                                Please provide a valid email address.
                            </div>
                        </div>
                    
                        <div class="mb-3 form-group">
                            <label for="password" class="form-lable">New Password</label>
                            <div class="input-group">
                                <input id="password" type="password" class="form-control mb-2" name="password" autofocus autocomplete="new-password">
                                <span class="input-group-text mb-2" id="togglePassword">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </span>
                            </div>
                           <div class="invalid-feedback" id="password_error">
                                Please enter password 
                           </div>
                        </div>
                       
                        <div class="mb-3 form-group">
                            <label for="password-confirmation" class="form-lable">Confirm Password</label>
                            <div class="input-group">
                                <input id="password-confirmation" type="password" class="form-control mb-2" name="password_confirmation"  autocomplete="new-password">
                                <span class="input-group-text mb-2" id="togglePasswordConfirmation">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </span>
                            </div>
                           <div class="invalid-feedback" id="password_confirmation_error">
                                Please Provide Confirm Password 
                           </div>
                        </div>
                    
                        <div class="form-group mt-3">
                            <button type="submit" id="submit" class="btn btn-primary">Submit</button>
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

@section('modals')
    @include('partials.home.login_modal');
@endsection

@push('scripts')
    <script src="{{ asset('js/home/password_reset.js') }}"></script>
@endpush
