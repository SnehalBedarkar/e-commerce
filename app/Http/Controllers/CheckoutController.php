<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
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
        }

        $deliveryCharges = 50;

        $total = $deliveryCharges + $subtotal;

        $itemsCount = $cartItems->count();
    
        // Pass cart items, subtotal, and item count to the view
        return view('home.checkout', compact('cartItems', 'subtotal', 'itemsCount' , 'deliveryCharges' , 'total'));
    }

    public function checkoutUpdate(Request $request)
    {
        $data = $request->all();

        $rules = [
            'user_id' => 'required|integer',
            'product_id' => 'required|integer',
            'item_id' => 'required|integer',
            'action' => 'required|string|in:increment,decrement',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ]);
        }

        $userId = $data['user_id'];
        $itemId = $data['item_id'];
        $productId = $data['product_id'];
        $action = $data['action'];

        $cartItem = CartItem::where('id', $itemId)
                            ->where('user_id', $userId)
                            ->where('product_id', $productId)
                            ->first();

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found',
            ]);
        }

        if ($action === 'increment') {
            // Increment quantity
            $cartItem->quantity += 1;
            $cartItem->save();
        } elseif ($action === 'decrement' && $cartItem->quantity > 1) {
            // Decrement quantity
            $cartItem->quantity -= 1;
            $cartItem->save();
        } elseif ($action === 'decrement' && $cartItem->quantity === 1) {
            // Delete item if quantity is 1 after decrement
            $cartItem->delete();
            $cartItem = null;
        }

        $cartItems = CartItem::where('user_id', $userId)->get();
        $itemsCount = $cartItems->count();
        $subtotal = $cartItems->sum(function ($item) {
            $productPrice = Product::where('id', $item->product_id)->value('price');
            return $productPrice * $item->quantity;
        });

        $deliveryCharges = 50;

        $total = $subtotal + $deliveryCharges;

        $newQuantity = $cartItem ? $cartItem->quantity : 0;
        $newTotal = $cartItem ? number_format($cartItem->quantity * $cartItem->product->price, 2) : 0;

        return response()->json([
            'success' => true,
            'message' => 'Cart item updated successfully',
            'new_quantity' => $newQuantity,
            'new_total' => $newTotal,
            'total' => $total,
            'itemsCount' => $itemsCount,
            'subtotal' => $subtotal,
            'cartItems' => $cartItems,
            'deliveryCharges' => $deliveryCharges,
        ]);
    }

    public function orderPlaced() {
        $userId = Auth::id();
        $orders = Order::where('user_id', $userId)->get(); // Fetch the orders for the authenticated user
        return view('home.order_place', ['orders' => $orders]); // Pass the orders to the view
    }
}
