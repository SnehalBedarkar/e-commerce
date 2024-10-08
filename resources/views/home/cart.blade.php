@extends('layouts.master')

@section('title', 'Cart')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/home/cart.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
@endpush

@section('header')
    @include('partials.home.header')
@endsection

@section('sidebar')
    @include('partials.home.sidebar')
@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
        @guest
            <div class="col-md-8">
                @forelse($cartItems as $item)
                    <div class="card mb-3 p-3 cart-item" data-item-id="{{ $item->product->id }}">
                        <div class="d-flex justify-content-between g-0">
                            <div class="mt-4">
                                <img src="{{ asset('storage/' . $item->product->image) }}" class="img-fluid rounded-start" alt="{{ $item->product->name }}" style="width: 100px; height: 100px; object-fit: cover;">
                            </div>
                            <div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->product->name }}</h5>
                                    <p class="card-text">Rs {{ $item->product->price }}</p>
                                    <input type="hidden" class="user-id" value="{{ Auth::id() }}">
                                    <input type="hidden" class="product-id" value="{{ $item->product->id }}">
                                    <input type="hidden" class="item-id" value="{{ $item->product->id }}">
                                    <div class="d-flex align-items-center">
                                        <button class="btn btn-secondary update" data-action="decrement">-</button>
                                        <input type="text" value="{{ $item->quantity }}" class="quantity-input form-control mx-2" readonly>
                                        <button class="btn btn-secondary update" data-action="increment">+</button>
                                    </div>
                                    <p class="card-text mt-2">Total: Rs <span id="item-total-{{ $item->product->id }}">{{ $item->itemTotalPrice }}</span></p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-center">
                                <button class="btn btn-danger remove_item" data-id="{{ $item->product->id }}" data-user-id="{{ Auth::id() }}" data-bs-target="#cartRemoveModal" data-bs-toggle="modal">Remove</button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="d-flex justify-content-center align-items-center flex-column" style="height: 300px;">
                        <div class="alert alert-info text-center">
                            <h4 class="alert-heading">Your Cart is Empty</h4>
                            <p class="mb-0">It looks like you have no items in your cart. Browse our products and add some items to your cart to continue shopping.</p>
                            <a href="{{ route('home') }}" class="btn btn-secondary btn-lg active" role="button" aria-pressed="true">Shop Now</a>
                        </div>
                    </div>
                @endforelse
            </div>
        @else
            <div class="col-md-8" id="cart-container">
                @forelse($cartItems as $item)
                    <div class="card mb-3 p-3 cart-item" data-item-id="{{ $item->id }}">
                        <div class="d-flex justify-content-between g-0">
                            <div class="mt-4">
                                <img src="{{ asset('storage/' . $item->product->image) }}" class="img-fluid rounded-start" alt="{{ $item->product->name }}" style="width: 100px; height: 100px; object-fit: cover;">
                            </div>
                            <div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->product->name }}</h5>
                                    <p class="card-text">Rs {{ $item->product->price }}</p>
                                    <input type="hidden" class="user-id" value="{{ Auth::id() }}">
                                    <input type="hidden" class="product-id" value="{{ $item->product->id }}">
                                    <input type="hidden" class="item-id" value="{{ $item->id }}">
                                    <div class="d-flex align-items-center">
                                        <button class="btn btn-secondary update" data-action="decrement">-</button>
                                        <input type="text" value="{{ $item->quantity }}" class="quantity-input form-control mx-2" readonly>
                                        <button class="btn btn-secondary update" data-action="increment">+</button>
                                    </div>
                                    <p class="card-text mt-2">Total: Rs <span id="item-total-{{ $item->id }}">{{ $item->itemTotalPrice }}</span></p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-center">
                                <button class="btn btn-danger remove_item" data-id="{{ $item->id }}" data-user-id="{{ Auth::id() }}" data-bs-target="#cartRemoveModal" data-bs-toggle="modal">Remove</button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="d-flex justify-content-center align-items-center flex-column" style="height: 300px;">
                        <div class="alert alert-info text-center">
                            <h4 class="alert-heading">Your Cart is Empty</h4>
                            <p class="mb-0">It looks like you have no items in your cart. Browse our products and add some items to your cart to continue shopping.</p>
                            <a href="{{ route('home') }}" class="btn btn-secondary btn-lg active" role="button" aria-pressed="true">Shop Now</a>
                        </div>
                    </div>
                @endforelse
            </div>
        @endguest

        {{-- Price Detail Card  --}}
        @unless ($cartItems->isEmpty())
            <div class="col-md-4" id="price-details">
                <div class="card">
                    <div class="card-header p-2">
                        <h5>Price Details</h5>
                    </div>
                    <hr>
                    <div class="card-body">
                        <p id="subtotal">Price <span id="items_count">({{ $itemCount }} items)</span> <span id="subtotal-value">{{ $subtotal }}</span> </p>
                        <!-- Display delivery charges -->
                        <p id="deliveryCharges">Delivery Charges: Rs {{ $deliveryCharges }}</p>
                    </div>
                    <div class="card-footer">
                        <h5 id="total">Total: Rs <span id="total-value">{{ $total }}</span> </h5>
                    </div>
                </div>
            </div>
        @endunless

        @unless($cartItems->isEmpty())
            <div class="col-2">
                <a class="btn btn-warning" href="{{ route('cart.place.order') }}">Checkout</a>
            </div>
        @endunless
    </div>
</div>
@endsection

@section('footer')
    @include('partials.home.footer')
@endsection

@section('modals')
    @include('partials.home.cart_remove')
@endsection

@push('scripts')
    <script src="{{ asset('js/home/cart.js') }}"></script>
@endpush

<script>
    window.homePageUrl = "{{ route('home') }}"; // Expose to global scope
</script>
