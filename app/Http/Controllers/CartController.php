<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{


    public function index()
    {
        $user = Auth::user();
        $cartItems = CartItem::with('product')->where('user_id', $user->id)->get();
        $products = Product::all();

        return view('cart.cart', compact('user', 'cartItems', 'products'));
    }

    public function calculateTotal(){
        
    }


    public function add(Request $request)
    {
        // Validate the request
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Create a new cart item for the authenticated user
        $cartItem = CartItem::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
        ]);

        return response()->json([
            'success' => true,
            'cartItem' => $cartItem,
            'redirect_url' => '/cart/'
        ]);
    }

    public function remove(string $id)
    {
        $cartItem  = CartItem::findOrFail($id);
        $cartItem->delete();
        return response()->json([
            'success' => true,
            'cartItemId' => $id,
            'message' => 'product deleted successfully'
        ]);
    }
}
