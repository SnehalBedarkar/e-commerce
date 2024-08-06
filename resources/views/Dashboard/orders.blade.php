@extends('layouts.master')

@section('title', 'Orders')

@section('header')
    @include('partials.dashboard.header')
@endsection

@section('sidebar')
    @include('partials.dashboard.sidebar')
@endsection

@section('content')
    <div class="container">
        <h4>Orders</h4>
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered table-striped table-hover table-responsive" id="orders_table">
                    <thead>
                        <tr>
                            <th>Order Number</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order )
                        <tr data-id="{{ $order->id }}">
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->total }}</td>
                            <td>{{ $order->status }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm" >View</button>
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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