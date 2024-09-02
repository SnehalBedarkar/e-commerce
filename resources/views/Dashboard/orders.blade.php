@extends('layouts.master')

@section('title', 'Orders')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard/orders.css') }}">
@endpush

@section('header')
    @include('partials.dashboard.header')
@endsection

@section('sidebar')
    @include('partials.dashboard.sidebar')
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mt-2">
                <h5>Orders</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-bordered " id="orders_table">
                        <thead class="thead-dark">
                            <tr>
                                <th>Order ID</th>
                                <th>Order Number</th>
                                <th>Prouduct Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                @foreach ($order->products as $index => $product)
                                    <tr data-id="{{ $order->id }}">
                                        @if ($loop->iteration == 1)
                                            <td rowspan="{{ $order->products->count() }}">{{ $order->id }}</td>
                                            <td rowspan="{{ $order->products->count() }}">{{ $order->order_number }}</td>
                                        @endif
                                        <td> {{ $loop->iteration }} - {{ $product->name }}</td>
                                        <td>{{ $product->pivot->quantity }}</td>
                                        <td>Rs {{ number_format($product->price, 2) }}</td>
                                        @if ($loop->iteration == 1)
                                            <td rowspan="{{ $order->products->count() }}">{{ $order->status }}</td>
                                            <td rowspan="{{ $order->products->count() }}">Rs {{ number_format($order->total, 2) }}</td>
                                            <td rowspan="{{ $order->products->count() }}">
                                                <button class="btn btn-primary">view</button>
                                                <button class="btn btn-secondary">Delete</button>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.dashboard.footer')
@endsection

@section('modals')
    @include('partials.dashboard.delete_modal')
    @include('partials.dashboard.view_modal')
@endsection

@push('scripts')
    <script src="{{ asset('js/dashboard/orders.js') }}"></script>
@endpush
