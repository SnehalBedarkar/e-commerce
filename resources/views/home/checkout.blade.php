@extends("layouts.master")

@section('title','Checkout')

@section('header')
    @include('partials.home.header')
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/home/checkout.css') }}">
@endpush

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8 mt-4">
            <!-- Login Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Login</h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-between">
                    <span>{{ Auth::user()->name }} {{ Auth::user()->phone_number }}</span>
                    <button type="button" class="btn btn-primary ms-auto" id="change_button" data-bs-toggle="modal" data-bs-target="#addressChangeModal">Change</button>
                </div>
            </div>
            <!-- Delivery Address Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Delivery Address</h5>
                </div>
                <div class="card-body">
                    <!-- Address content -->
                </div>
            </div>
            <!-- Order Summary Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Order Summary</h4>
                </div>
                <div class="card-body">
                    @foreach ($cartItems as $item)
                    <div class="d-flex align-items-center justify-content-between mb-3 cart-item" id="{{ $item->id }}">
                        <div class="d-flex align-items-center">
                            <input type="hidden" class="user-id" value="{{ Auth::id() }}">
                            <input type="hidden" class="product-id" value="{{ $item->product->id }}">
                            <img src="{{ asset('storage/'.$item->product->image) }}" alt="{{ $item->product->name }}" class="img-thumbnail me-3" width="100px">
                            <div>
                                <h6 class="mb-0">{{ $item->product->name }}</h6>
                                <small class="text-muted">Rs {{ number_format($item->product->price, 2) }}</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <button type="button" class="btn btn-outline-secondary me-2 update" data-action="decrement">-</button>
                            <input type="text" class="quantity-input form-control text-center me-2" value="{{ $item->quantity }}" style="width: 50px;" readonly>
                            <button type="button" class="btn btn-outline-secondary me-2 update" data-action="increment">+</button>
                            <span id="item-total-{{ $item->id }}" class="fw-bold">Rs {{ number_format($item->product->price * $item->quantity, 2) }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <!-- Payment Options Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Payment Options</h5>
                </div>
                <div class="card-body">
                   <form id="paymentForm">
                        <input type="hidden" id="total" value="{{ $total }}">
                        <button type="button" id="pay_button" class="btn btn-primary mb-2 mt-2">Pay with Razorpay</button>
                   </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mt-4">
            <div class="card sticky-card">
                <div class="card-header">
                    Price Details
                </div>
                <div class="card-body">
                    <p id="subtotal"> Subtotal : Price <span id="items_count">({{ $itemsCount }} items)</span> <span id="subtotal-value">{{ $subtotal }}</span> </p>
                    <span id="deliveryCharges">Delivery Charges : {{ $deliveryCharges }}</span>
                    <hr>
                    <span id="total">Total {{ $total }}</span>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <a href="{{ route('home') }}" class="btn btn-secondary mb-2 mt-2">Continue Shopping</a>
                <button type="button" class="btn btn-primary mb-2 mt-2" id="place_order" data-user-id="{{ Auth::id() }}">Place Order</button>
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
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/home/checkout.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#pay_button').on('click', function(e) {
                e.preventDefault();

                var total = $('#total').val() * 100; // Total amount in paise (subunits)

                var options = {
                    "key": "{{ env('RAZORPAY_KEY_ID') }}", // Enter the Key ID generated from the Dashboard
                    "amount": total, // Amount is in currency subunits (i.e., 100 paise = 1 INR)
                    "currency": "INR",
                    "name": "Your Company Name",
                    "description": "Payment for Order",
                    "image": "https://example.com/your_logo",
                    "handler": function (response){
                        // You can handle the success response here
                        alert('Payment successful! Razorpay payment ID: ' + response.razorpay_payment_id);
                        // Optionally, you can send the response data to your backend for further processing
                    },
                    "prefill": {
                        "name": "{{ Auth::user()->name }}",
                        "email": "{{ Auth::user()->email }}",
                        "contact": "{{ Auth::user()->phone_number }}"
                    },
                    "theme": {
                        "color": "#3399cc"
                    }
                };

                var rzp1 = new Razorpay(options);
                rzp1.open();
            });
        });
    </script>
@endpush
