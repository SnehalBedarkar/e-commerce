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
        <div id="main_content" class="col-12">
            @foreach ($orders as $order)
                <div class="card mb-3 mt-2 shadow-sm border-0 w-100">
                    <div class="card-body p-3">
                        <div class="row mb-2">
                            <div class="col-6">
                                <p class="card-text"><strong>Total:</strong> Rs {{ number_format($order->total, 2) }}</p>
                            </div>
                            <div class="col-6 text-end">
                                <p class="card-text"><strong>Status:</strong> {{ $order->status }}</p>
                            </div>
                        </div>
                        @foreach ($order->products as $product)
                            <div class="row align-items-center mb-3">
                                <div class="col-2">
                                    <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded" style="max-height: 80px;">
                                </div>
                                <div class="col-10">
                                    <h6 class="product-name m-0">{{ $product->name }}</h6>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
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
