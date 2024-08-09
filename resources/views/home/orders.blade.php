@extends('layouts.master')

@section('title', 'Orders')

@push('styles')
     <link rel="stylesheet" href="{{ asset('css/home/orders.css') }}">
@endpush

@section('header')
    @include('partials.home.header')
@endsection

@section('sidebar')
    @include('partials.home.sidebar')
@endsection

@section('content')
    <div id="container">
        <div class="row">
            <div class="col-12" id="main_content">
                <table id="orders_table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Order Number</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Order Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            @foreach ($order->products as $index => $product)
                                <tr data-id="{{ $order->id }}">
                                    @if ($index == 0)
                                        <td rowspan="{{ $order->products->count() }}">{{ $order->id }}</td>
                                        <td rowspan="{{ $order->products->count() }}">{{ $order->order_number }}</td>
                                    @endif
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->pivot->quantity }}</td>
                                    <td>Rs {{ number_format($product->price, 2) }}</td>
                                    @if ($index == 0)
                                        <td rowspan="{{ $order->products->count() }}">{{ $order->status }}</td>
                                        <td rowspan="{{ $order->products->count() }}">Rs {{ number_format($order->total, 2) }}</td>
                                    @endif
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    @include('partials.home.login_modal')
    @include('partials.home.register_modal')
@endsection

@section('footer')
    @include('partials.home.footer')
@endsection

@push('scripts')
    <script src="{{ asset('js/home/orders.js') }}"></script>
@endpush
