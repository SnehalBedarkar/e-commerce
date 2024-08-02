@extends('layouts.master')

@section('title', 'Orders')

@section('header')
    @include('partials.home.header')
@endsection

@section('sidebar')
    @include('partials.home.sidebar')
@endsection

@section('content')
    <div id="container">
        <div class="row">
            <div class="col-3">
                <div class="card">
                    <div class="card-header">
                        <h4>Filters</h4>
                    </div>
                    <div class="card-body">
                        <h5>Order Status</h5>
                        <form id="orders_status">
                            <p>
                                <input type="checkbox" id="on_the_way" name="orders_status[]" value="on_the_way"> 
                                <label for="on_the_way">On The Way</label>
                            </p>
                            <p>
                                <input type="checkbox" id="delivered" name="orders_status[]" value="delivered">
                                <label for="delivered">Delivered</label>
                            </p>
                            <p>
                                <input type="checkbox" id="cancelled" name="orders_status[]" value="cancelled">
                                <label for="cancelled">Cancelled</label>
                            </p>
                            <p>
                                <input type="checkbox" id="returned" name="orders_status[]" value="returned">
                                <label for="returned">Returned</label>
                            </p>
                            <button type="button" id="submit_status">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-9" id="main_content">
                <table id="orders_table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
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
                            @foreach ($order->products as $product)
                                <tr data-id="{{ $order->id }}">
                                    <td>{{ $order->order_number }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->pivot->quantity }}</td>
                                    <td>Rs {{ number_format($product->price, 2) }}</td>
                                    <td>{{ $order->status }}</td>
                                    <td>Rs {{ number_format($order->total, 2) }}</td>
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
    <script src="{{ asset('js/home.js') }}"></script>
@endpush
