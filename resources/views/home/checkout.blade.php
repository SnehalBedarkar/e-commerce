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
            <div class="col-8">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-2">
                            <div class="card-header">
                                <h5>Login Or Signup</h5>
                                @guest
                                <button type="button" class="btn btn-primary" data-bs-target="#loginModal" data-bs-toggle="modal">Login</button>
                                @endguest
                            </div>
                            <div class="card-body d-flex align-items-center justify-content-between ">
                                @auth
                                    <div>
                                        <h5>Login</h5>
                                    </div>
                                    <span id="name">{{ Auth::user()->name }} {{ Auth::user()->phone_number }}</span>
                                    <button type="button" class="btn btn-primary ms-auto" id="change_button">Change</button>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-2 shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Address Details</h5>
                            </div>
                            <div class="card-body">
                                @auth
                                    <button type="button" class="btn btn-primary ms-auto mb-2" data-bs-target="#addAddressModal" data-bs-toggle="modal">Add New Address</button>
                                    @foreach ($addresses as $address)
                                    <div class="form-group row align-items-center mb-3 border p-3 rounded address-item" id="address_id-{{ $address->id }}">
                                        <div class="col-1">
                                            <div class="form-check">
                                                <input type="radio" name="address" id="address{{ $address->id }}" class="form-check-input" value="{{ $address->id }}">
                                                <label class="form-check-label" for="address{{ $address->id }}"></label>
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <label for="address{{ $address->id }}" class="mb-0">
                                                <strong>{{ $address->name }}</strong> - <span class="text-muted">{{ $address->phone_number }}</span>
                                            </label>
                                        </div>
                                        <div class="col-2">
                                            <span class="text-muted">{{ $address->type }}</span>
                                        </div>
                                        <div class="col-1 text-end">
                                            <button type="button" class="btn btn-outline-primary btn-sm edit-btn" data-id="{{ $address->id }}">Edit</button>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    <p class="text-muted">Please log in to manage your addresses.</p>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card mb-2">
                            <div class="card-header">
                                <h5>Order Summary</h5>
                            </div>
                            <div class="card-body">
                                @auth
                                    @foreach ($cartItems as $item)
                                    <div class="row  cart-item" id="{{ $item->id }}">
                                        <div class="col-3">
                                            <input type="hidden" class="user-id" value="{{ Auth::id() }}">
                                            <input type="hidden" class="product-id" value="{{ $item->product->id }}">
                                            <img src="{{ asset('storage/'.$item->product->image) }}" alt="{{ $item->product->name }}" class="img-thumbnail me-3 img-fluid" width="100px">
                                        </div>
                                        <div class="col-3">
                                            <h6 class="mb-0">{{ $item->product->name }}</h6>
                                            <small class="text-muted">Rs {{ number_format($item->product->price, 2) }}</small>
                                        </div>
                                        <div class="col-3  d-flex justify-content-between align-items-center">
                                            <button type="button" class="btn btn-outline-secondary update" data-action="decrement">-</button>
                                            <input type="text" class="quantity-input form-control text-center mx-2" value="{{ $item->quantity }}" style="width: 50px;" readonly>
                                            <button type="button" class="btn btn-outline-secondary update" data-action="increment">+</button>
                                        </div>
                                        <div class="col-3 align-self-center text-end">
                                            <span id="item-total-{{ $item->id }}" class="fw-bold">Rs {{ number_format($item->product->price * $item->quantity, 2) }}</span>
                                        </div>
                                    </div>
                                    @endforeach
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-2">
                    <div class="card-header">
                        <h5>Payment Options</h5>
                    </div>
                    <div class="card-body">
                        @auth
                            <form id="paymentForm">
                                <input type="hidden" id="total_amount" value="{{ $total }}">
                                <button type="button" id="pay_button"  data-user-id="{{ Auth::id() }}" class="btn btn-primary mb-2 mt-2">Pay with Razorpay</button>
                            </form>
                        @endauth
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('home') }}" class="btn btn-secondary mb-2 mt-2">Continue Shopping</a>
                    <button type="button" class="btn btn-primary mb-2 mt-2" id="place_order">Place Order</button>
                </div>
            </div>

            <div class="col-4">
                @auth
                    <div class="card">
                        <div class="card-header">
                            <h5>Payment Details</h5>
                        </div>
                        <div class="card-body">
                            @auth
                                <p id="subtotal">Subtotal: Price <span id="items_count">({{ $itemsCount }} items)</span> <span id="subtotal-value">{{ $subtotal }}</span></p>
                                <span id="deliveryCharges">Delivery Charges: {{ $deliveryCharges }}</span>
                                <hr>
                                <span id="final_amount">Total {{ $total }}</span>
                            @endauth
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.home.footer')
@endsection

@section('modals')
    @include('partials.home.login_modal')
    @include('partials.home.add_new_address_modal')
@endsection

@push('scripts')
    <script src="{{ asset('js/home/checkout.js') }}"></script>
    <script>
        window.RAZORPAY_KEY_ID = "{{ env('RAZORPAY_KEY_ID') }}";
    </script>
@endpush
