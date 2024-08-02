<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\CartItem;

class CartController extends Controller
{


    // public function index(){
    //     $cartItems = CartItem::all();
    //     return view('car')
    // }



    public function showCart() {
        $userId = Auth::id();
        $cartItems = CartItem::where('user_id', $userId)->with('product')->get();
    

        $deliveryCharges = 50;
    
        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
        $total = $subtotal + $deliveryCharges;

        $cartItems->each(function ($item) {
            $item->itemTotalPrice = $item->product->price * $item->quantity;
        });

        $itemCount = $cartItems->count();
        return view('home.cart', compact('cartItems', 'total', 'deliveryCharges', 'subtotal','itemCount'));
    }


    public function addToCart(Request $request)
    {
        $data = $request->all();

        $rules = [
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
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
        $userId = $data['user_id'];
        $quantity = $data['quantity'];

        // Find the existing cart_item for the given product and user
        $cartItem = CartItem::where('user_id', $userId)
                            ->where('product_id', $productId)
                            ->first();

        if ($cartItem) {
            // Product exists in the cart, update the quantity
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            // Product does not exist in the cart, create a new cart item
            $cartItem = CartItem::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        // For other actions, return only the updated or created cart item
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
            'user_id' => 'required|integer',
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

        // Extract individual values
        $userId = $data['user_id'];
        $itemId = $data['item_id'];
        $productId = $data['product_id'];
        $action = $data['action'];
    
        // find that if cartItesm exist for this user 

        $cartItem = CartItem::where('id', $itemId)
                            ->where('product_id', $productId)
                            ->where('user_id', $userId)
                            ->first(); 

        if ($cartItem) {
            if ($action === 'increment') {
                $cartItem->quantity++;
                $cartItem->save();
            } elseif ($action === 'decrement') {
                if ($cartItem->quantity > 1) {
                    // Decrement the quantity but ensure it does not go below 1
                    $cartItem->quantity--;
                    $cartItem->save();
                } elseif ($cartItem->quantity === 1) {
                    $cartItem->quantity--;
                    $cartItem->delete();
                }
            }

            // Calculate total for all items in the cart
            $cartItems = CartItem::where('user_id', $userId)->get();
            $subtotal = $cartItems->sum(function ($item) {
                $productPrice = Product::where('id', $item->product_id)->value('price');
                return $productPrice * $item->quantity;
            });

            $deliveryCharges = 50;

            $total = $subtotal + $deliveryCharges ;

            $quantity = $cartItem ? $cartItem->quantity : 0;
            $itemTotalPrice = $cartItem ? Product::where('id', $productId)->value('price') * $quantity : 0; 

            return response()->json([
                'success' => true,
                'message' => 'Item updated successfully',
                'cartItem' => $cartItem,
                'cartItems' => $cartItems,
                'itemTotalPrice' => $itemTotalPrice,
                'deliveryCharges' => $deliveryCharges,
                'quantity' => $quantity, // Return the updated quantity
                'subtotal' => $subtotal,
                'total' => $total
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Item not found'
            ]);
        }
    }


    public function remove(Request $request){

        $data = $request->all();

        $rules = [
            'user_id' => 'required|integer',
            'item_id' => 'required|integer',
        ];

        $validator =Validator::make($data,$rules);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'validation fail',
                'errors' => $validator->error()->all()
            ]);
        }

        
        $userId = $data['user_id'];
        $itemId = $data['item_id'];

        

        $cartItem = CartItem::where('user_id',$userId)
                             ->where('id',$itemId)
                             ->first();
        if($cartItem){
            $cartItem->delete();

            // now find out cartitems for specific user remaining

            $cartItems = CartItem::where('user_id',$userId)->get();

            $subtotal = $cartItems->sum(function($item){
                return $item->product->price * $item->quantity;
            });

            $deliveryCharges = 50;
            $total = $subtotal + $deliveryCharges;

            return response()->json([
                'success' => true,
                'message' => 'item deleted successfully',
                'cartItem' => $cartItem,
                'cartItems' => $cartItems,
                'total' => $total,
                'subtotal' => $subtotal
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'item nof found'
            ]);
        }
    }

    public function placeOrder(){
        return redirect()->route('checkout');
    }
}
