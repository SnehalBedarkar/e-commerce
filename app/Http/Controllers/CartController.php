<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\CartItem;

class CartController extends Controller
{
    public function showCart() {
        $userId = Auth::id();
        $deliveryCharges = 50;

        if (Auth::check()) {
            $cartItems = CartItem::where('user_id', $userId)->with('product')->get();
        } else {
            $cartItems = session()->get('cart', []);
            $cartItems = collect($cartItems)->map(function($item){
                $product = Product::find($item['product_id']);
                return (object)[
                    'product' => $product,
                    'quantity' => $item['quantity'],
                ];
            });
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
        $total = $subtotal + $deliveryCharges;

        $cartItems->each(function ($item) {
            $item->itemTotalPrice = $item->product->price * $item->quantity;
        });

        $itemCount = $cartItems->count();

        return view('home.cart', compact('cartItems', 'total', 'deliveryCharges', 'subtotal', 'itemCount'));
    }

    public function addToCart(Request $request)
    {
        $data = $request->all();

        $rules = [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        $productId = $data['product_id'];
        $quantity = $data['quantity'];

        if (Auth::check()) {
            $userId = Auth::id();

            $cartItem = CartItem::where('user_id', $userId)
                                ->where('product_id', $productId)
                                ->first();

            if ($cartItem) {
                $cartItem->quantity += $quantity;
                $cartItem->save();
            } else {
                $cartItem = CartItem::create([
                    'user_id' => $userId,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ]);
            }
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] += $quantity;
            } else {
                $cart[$productId] = [
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ];
            }

            session()->put('cart', $cart);

            $cartItem = [
                'product_id' => $productId,
                'quantity' => $cart[$productId]['quantity'],
            ];
        }

        return response()->json([
            'success' => true,
            'cartItem' => $cartItem,
            'redirect_url' => '/cart'
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->all();

        $rules = [
            'item_id' => 'required|integer',
            'product_id' => 'required|integer',
            'action' => 'required|string|in:increment,decrement',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $itemId = $data['item_id'];
        $productId = $data['product_id'];
        $action = $data['action'];

        $quantity = 0;
        $subtotal = 0;
        $deliveryCharges = 50;
        $total = 0;
        $itemTotalPrice = 0;

        if (Auth::check()) {
            $userId = Auth::id();
            $cartItem = CartItem::where('id', $itemId)
                                ->where('product_id', $productId)
                                ->where('user_id', $userId)
                                ->first();

            if ($cartItem) {
                if ($action === 'increment') {
                    $cartItem->quantity++;
                } elseif ($action === 'decrement' && $cartItem->quantity > 1) {
                    $cartItem->quantity--;
                } elseif ($action === 'decrement' && $cartItem->quantity === 1) {
                    $cartItem->delete();
                }
                $cartItem?->save();

                $cartItems = CartItem::where('user_id', $userId)->with('product')->get();
                $subtotal = $cartItems->sum(function ($item) {
                    return $item->product->price * $item->quantity;
                });

                $total = $subtotal + $deliveryCharges;

                if ($cartItem) {
                    $quantity = $cartItem->quantity;
                    $itemTotalPrice = $cartItem->product->price * $quantity;
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Item updated successfully',
                    'cartItem' => $cartItem,
                    'cartItems' => $cartItems,
                    'itemTotalPrice' => $itemTotalPrice,
                    'deliveryCharges' => $deliveryCharges,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                    'total' => $total
                ]);

            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found'
                ]);
            }
        } else {
            $cart = session()->get('cart', []);
            
            if (isset($cart[$productId])) {
                if ($action === 'increment') {
                    $cart[$productId]['quantity']++;
                } elseif ($action === 'decrement' && $cart[$productId]['quantity'] > 1) {
                    $cart[$productId]['quantity']--;
                } elseif ($action === 'decrement' && $cart[$productId]['quantity'] === 1) {
                    unset($cart[$productId]);
                }
            }
            session()->put('cart', $cart);

            $subtotal = 0;
            foreach ($cart as $product) {
                $productPrice = Product::where('id', $product['product_id'])->value('price');
                $subtotal += $productPrice * $product['quantity'];
            }

            $total = $subtotal + $deliveryCharges;

            if (isset($cart[$productId])) {
                $quantity = $cart[$productId]['quantity'];
                $itemTotalPrice = Product::where('id', $productId)->value('price') * $quantity;
            }

            return response()->json([
                'success' => true,
                'message' => 'Item updated successfully',
                'cartItem' => isset($cart[$productId]) ? $cart[$productId] : null,
                'cartItems' => $cart,
                'itemTotalPrice' => $itemTotalPrice ?? 0,
                'deliveryCharges' => $deliveryCharges,
                'quantity' => $quantity ?? 0,
                'subtotal' => $subtotal,
                'total' => $total
            ]);
        }
    }

    public function remove(Request $request)
    {
        $data = $request->all();

        $rules = [
            'item_id' => 'required|integer',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()->all()
            ]);
        }

        $itemId = $data['item_id'];
        $userId = Auth::check() ? Auth::id() : $data['user_id'];

        $cartItem = CartItem::where('user_id', $userId)
                             ->where('id', $itemId)
                             ->first();

        if ($cartItem) {
            $cartItem->delete();

            $cartItems = CartItem::where('user_id', $userId)->with('product')->get();
            $subtotal = $cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });

            $deliveryCharges = 50;
            $total = $subtotal + $deliveryCharges;

            return response()->json([
                'success' => true,
                'message' => 'Item deleted successfully',
                'cartItem' => $cartItem,
                'cartItems' => $cartItems,
                'total' => $total,
                'subtotal' => $subtotal
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Item not found'
            ]);
        }
    }

    public function placeOrder()
    {
        return redirect()->route('checkout');
    }
}
