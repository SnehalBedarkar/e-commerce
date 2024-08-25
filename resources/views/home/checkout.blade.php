@extends("layouts.master")

@section('title','Checkout')

@section('header')
    @include('partials.home.header')
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/home/checkout.css') }}">
@endpush

@section('content')
    <div id="conainer">
        <div class="container">
            <div class="row">
                <div class="col-8">

                    <!-- Login Card -->

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

                    {{-- Address Card --}}

                    <div class="card mb-2">
                        <div class="card-header">
                            <h5>Address Details</h5> <!-- Unified heading for both auth and guest -->
                        </div>
                        <div class="card-body">
                            @auth
                                <!-- Content for authenticated users -->
                                    <button type="button" class="btn btn-primary ms-auto mb-2" id="add_address">Add New Address</button>
                                    @foreach ($addresses as $address)
                                    <div class="form-group row align-items-center mb-3 border p-3 rounded" id="address_id-{{ $address->id }}">
                                        <!-- Radio Button -->
                                        <div class="col-1">
                                            <div class="form-check">
                                                <input type="radio" name="address" id="address{{ $address->id }}" class="form-check-input" value="{{ $address->id }}">
                                                <label class="form-check-label" for="address{{ $address->id }}"></label>
                                            </div>
                                        </div>
                                        
                                        <!-- User Name and Phone Number -->
                                        <div class="col-8">
                                            <label for="address{{ $address->id }}" class="mb-0">
                                                {{ $address->name }} - {{ $address->phone_number }}
                                            </label>
                                        </div>
                                        
                                        <!-- Address Type/Description -->
                                        <div class="col-2">
                                            <span class="text-muted">{{ $address->type }}</span>
                                        </div>
                                        
                                        <!-- Edit Button -->
                                        <div class="col-1 text-right">

                                            <button type="button" class="btn btn-primary edit-btn" data-id="{{ $address->id }}">Edit</button>
                                        </div>
                                    </div>
                                    @endforeach
                            @else
                            @endauth
                        </div>
                    </div>
                    


                    <div class="card mb-2">
                        <div class="card-header">
                           <h5>Order Summary</h5>
                        </div>
                        <div class="card-body">
                            @auth
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
                            @endauth
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
