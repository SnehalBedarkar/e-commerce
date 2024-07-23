<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @extends('Dashboard.layouts.master');
    <div class="container mt-5">
        <h5 class="text-end">Welcome, {{ Auth::user()->name }}</h5>
        <h2>Your Cart</h2>
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    @foreach ($cartItems as $cartItem)
                    <div class="col-md-4 mb-4" id="cart-item-{{ $cartItem->id }}">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $cartItem->product->name }}</h5>
                                <p class="card-text">Quantity: <span class="quantity-display">{{ $cartItem->quantity }}</span></p>
                                <p class="card-text">Price: {{ $cartItem->product->price }}</p>
                                <div class="quantity-control">
                                    <button type="button" class="btn btn-sm btn-outline-secondary decrease-quantity" data-id="{{ $cartItem->id }}">-</button>
                                    <span class="quantity">{{ $cartItem->quantity }}</span>
                                    <button type="button" class="btn btn-sm btn-outline-secondary increase-quantity" data-id="{{ $cartItem->id }}">+</button>
                                </div>
                                <button type="button" class="btn btn-outline-danger remove-button text-end mt-2" data-id="{{ $cartItem->id }}">Remove</button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-4">
                <div class="price-details">
                    <h3>Price Details</h3>
                    @if(count($cartItems) > 0)
                        <div>
                            <p class="total_items">Total Items: {{ count($cartItems) }}</p>
                            {{-- <p>Subtotal: ${{ $subtotal }}</p>
                            <p>Shipping: ${{ $shipping }}</p>
                            <p class="total">Total: ${{ $total }}</p> --}}
                        </div>
                    @else
                        <p>Your Cart is empty</p>
                    @endif
                </div>
            </div>
            
        </div>
    </div>    
</body>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $('.remove-button').on('click',function(){
            let productId = $(this).data('id');
            $.ajax({
                url:'/cart/remove/'+ productId,
                type:'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success:function(repsonse){
                    if(repsonse.success){
                        $('#cart-item-' + cartItemId).remove();
                    }
                },
                error:function(xhr,status,error){
                    // 
                }
            });
        });
    });
</script>
