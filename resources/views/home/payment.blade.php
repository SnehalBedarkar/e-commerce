@extends('layouts.master');

@section('title','payment')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/home/payment.css') }}">
@endpush

@section('header')
    @include('partials.home.header')
@endsection

@section('content')
<div class="container">

    <div class="card mt-5">
        <h3 class="card-header p-3">Laravel 11 Razorpay Payment Gateway Integration - ItSolutionStuff.com</h3>
        <div class="card-body">

            @session('error')
                <div class="alert alert-danger" role="alert"> 
                    {{ $value }}
                </div>
            @endsession

            @session('success')
                <div class="alert alert-success" role="alert"> 
                    {{ $value }}
                </div>
            @endsession

            <form id="payment-form" action="{{ route('razorpay.payment.store') }}" method="POST" class="text-center">
                @csrf
                <button id="rzp-button1" class="btn btn-primary">Pay Now</button>
            </form>
        </div>
    </div>
</div>
@endsection


@push('scripts')
    <script  src="{{ asset('js/home/payment.js') }}"></script>
@endpush

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    // Add Razorpay script to the button click event
    document.getElementById('rzp-button1').onclick = function(e){
        e.preventDefault();

        var options = {
            "key": "{{ env('rzp_test_hZ4ifnfZPZ6HBA') }}", // Enter the Key ID generated from the Dashboard
            "amount": "1000", // Amount is in currency subunits. Default currency is INR. Hence, 1000 subunits = 10 INR
            "currency": "INR",
            "name": "ItSolutionStuff.com",
            "description": "Test Transaction",
            "image": "https://www.itsolutionstuff.com/frontTheme/images/logo.png",
            "handler": function (response){
                // Handle successful payment here
                document.getElementById('payment-form').submit();
            },
            "prefill": {
                "name": "John Doe",
                "email": "john.doe@example.com"
            },
            "theme": {
                "color": "#ff7529"
            }
        };
        
        var rzp1 = new Razorpay(options);
        rzp1.open();
    }
</script>