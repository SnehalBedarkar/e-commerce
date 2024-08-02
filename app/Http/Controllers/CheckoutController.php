<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;

class CheckoutController extends Controller
{
    public function showCheckout()
    {
        $userId = Auth::id();
    
        // Retrieve cart items for the authenticated user with product details
        $cartItems = CartItem::where('user_id', $userId)->with('product')->get();
    
        $subtotal = 0;
        $itemCount = 0;
    
        // Calculate subtotal and item count
        foreach ($cartItems as $item) {
            $productPrice = $item->product->price; // Assuming 'price' is a column in the 'products' table
            $quantity = $item->quantity;
            $subtotal += $productPrice * $quantity;
            $itemCount += $quantity;
        }
    
        // Pass cart items, subtotal, and item count to the view
        return view('home.checkout', compact('cartItems', 'subtotal', 'itemCount'));
    }

    public function orderPlaced() {
        $userId = Auth::id();
        $orders = Order::where('user_id', $userId)->get(); // Fetch the orders for the authenticated user
        return view('home.order_place', ['orders' => $orders]); // Pass the orders to the view
    }
}
