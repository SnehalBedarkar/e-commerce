<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\CartItem;


class CheckoutController extends Controller
{
    public function showCheckout()
    {
        if (Auth::check()) {
            $userId = Auth::id();
            $cartItems = CartItem::where('user_id', $userId)->with('product')->get();
        } else {
            $cartItems = session()->get('cart', []);
            $cartItems = collect($cartItems)->map(function ($item) {
                $product = Product::find($item['product_id']);
                return (object)[
                    'product' => $product,
                    'quantity' => $item['quantity'],
                ];
            });
        }

        $subtotal = 0;
        $itemsCount = 0;

        // Calculate subtotal and item count
        foreach ($cartItems as $item) {
            $productPrice = $item->product->price; // Assuming 'price' is a column in the 'products' table
            $quantity = $item->quantity;
            $subtotal += $productPrice * $quantity;
            $itemsCount += $quantity; // Accumulate total item count
        }

        $deliveryCharges = 50; // Delivery charges are constant in this example
        $total = $subtotal + $deliveryCharges;

        $addressCount = Address::count();
        $addresses = Address::all();

        // Pass cart items, subtotal, item count, and addresses to the view
        return view('home.checkout', compact('cartItems', 'subtotal', 'itemsCount', 'deliveryCharges', 'total', 'addressCount', 'addresses'));
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

        if($subtotal === 0){
            $deliveryCharges == 0;
        }

        

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
}
