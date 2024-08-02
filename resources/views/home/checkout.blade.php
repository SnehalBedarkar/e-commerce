@extends("layouts.master")

@section('title','Checkout')

@section('header')
    @include('partials.home.header')
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8">   
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Login</h5>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <span>{{ Auth::user()->name }} {{ Auth::user()->phone_number }}</span>
                        <button type="button" class="btn btn-primary ms-auto" id="change_button" data-bs-toggle="modal" data-bs-target="#addressChangeModal">Change</button>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Delivery Address</h5>
                    </div>
                    <div class="card-body">
                        
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="container mt-5">
                        <h4>Order Summary</h4>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5>Products</h5>
                            </div>
                            <div class="card-body">
                                @foreach ($cartItems as $item)
                                    <div class="d-flex align-items-center justify-content-between mb-3" data-item-id="{{ $item->id }}">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('storage/'.$item->product->image) }}" alt="{{ $item->product->name }}" class="img-thumbnail me-3" width="100px">
                                            <div>
                                                <h6 class="mb-0">{{ $item->product->name }}</h6>
                                                <small class="text-muted">Rs {{ number_format($item->product->price, 2) }}</small>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <button type="button" class="btn btn-outline-secondary me-2">-</button>
                                            <input type="text" class="form-control text-center me-2" value="{{ $item->quantity }}" style="width: 50px;">
                                            <button type="button" class="btn btn-outline-secondary me-2">+</button>
                                            <span class="fw-bold">Rs {{ number_format($item->product->price * $item->quantity, 2) }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('home') }}" class="btn btn-secondary mb-2">Continue Shopping</a>
                            <button type="button" class="btn btn-primary mb-2" id="place_order" data-user-id="{{ Auth::id() }}">Place Order</button>
                        </div>
                    </div>   
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Payment Options</h5>
                    </div>
                    <div class="card-body">

                    </div>
                </div>                    
            </div>
            <div class="col-4">
               <div class="card">
                    <div class="card-header">
                        Price Details
                    </div>
                    <div class="card-body">
                        <p id="subtotal">Price <span id="items_count">({{ $itemCount }} items)</span> <span id="subtotal-value">{{ $subtotal }}</span> </p>
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
    @include('partials.home.address_change')
@endsection

@push('scripts')
    <script src="{{ asset('js/home.js') }}"></script>
@endpush