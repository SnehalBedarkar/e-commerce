@extends('layouts.master')  

@section('title','Password Reset')

@section('header')
    @include('partials.home.header')
@endsection

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Set New Password') }}

                </div>
                <div class="card-body">
                    <form id="password_reset_form">

                        <div class="form-group">
                            <label for="password" class="form-lable">New Password</label>
                            <input id="password" type="password" class="form-control" name="password" required autofocus>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm">{{ __('Confirm New Password') }}</label>
                            <input id="password-confirmation" type="password" class="form-control" name="password_confirmation" required>
                        </div>

                        <div class="form-group mt-2">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Set New Password') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
