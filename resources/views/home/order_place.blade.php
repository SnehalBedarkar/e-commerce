@extends('layouts.master')

@section('title', 'Order Placed')

@push('styles')
     <link rel="stylesheet" href="{{ asset('css/home/order-placed.css') }}">
@endpush

@section('header')
    @include('partials.home.header')
@endsection

@section('sidebar')
    @include('partials.home.sidebar')
@endsection

@section('content')
    <div class="container mt-5">
        <div class="text-center">
            <h1 class="mb-4">Thank You for Your Order!</h1>
            <p class="lead">Your order has been successfully placed.</p>
            <p class="text-muted" id="order_number">Order Number: <strong>{{ $order->order_number }}</strong></p>
            <div class="order-details mt-4">
                <h4>Order Summary</h4>
                <div class="card">
                    <div class="card-body">
                        <ul class="list-group">
                            {{-- @foreach($order->items as $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $item->product->name }}
                                    <span>Qty: {{ $item->quantity }}</span>
                                    <span>Rs {{ number_format($item->total_price, 2) }}</span>
                                </li>
                            @endforeach --}}
                        </ul>
                    </div>
                </div>

                <div class="mt-3">
                    <p class="lead">Subtotal: Rs </p>
                    <p class="lead">Delivery Charges: Rs </p>
                    <h4>Total: Rs</h4>
                </div>
            </div>

            <div class="mt-5">
                <a href="{{ route('home') }}" class="btn btn-primary">Return to Home</a>
                <a href="#" class="btn btn-secondary">View Order Details</a>
            </div>
        </div>
    </div>

@endsection

@section('footer')
    @include('partials.home.footer')
@endsection

@push('scripts')
    <script src="{{ asset('js/home/order_placed.js') }}"></script>
@endpush