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
                @foreach ($order->products as $index => $product)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-2">
                                    <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="img-fluid">
                                </div>
                                <div class="col-4">
                                    <h6 class="product-name">{{ $product->name }}</h6>
                                </div>
                                @if ($index === 0)
                                    <div class="col-2">
                                        <p class="card-text"><strong>Total:</strong> Rs {{ number_format($order->total, 2) }}</p>
                                    </div>
                                    <div class="col-4">
                                        <p class="card-text"><strong>Status:</strong> {{ $order->status }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
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
