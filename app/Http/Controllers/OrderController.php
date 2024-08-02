<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class OrderController extends Controller
{

   public function userSpecificOrders()
   {
      $userId = Auth::id();

      // Fetch orders with products for the logged-in user
      $orders = Order::where('user_id', $userId)
                     ->with('products')  // Eager load products
                     ->get();
      // return $orders;
      return view('home.orders', compact('orders'));
   }
  

   public function ordersStatus(Request $request)
   {
      $userId = Auth::id();
      // Capture all incoming request data
      $data = $request->all();
      
      // Extract statuses from the data array
      $statuses = $data['statuses'] ?? [];
      
      // Fetch orders based on the selected statuses
      $orders = Order::whereIn('status', $statuses)
                     ->where('user_id',$userId)->get();

      // Return the fetched orders in the response
      return response()->json([
         'success' => true,
         'message' => 'Orders fetched successfully',
         'orders' => $orders
      ]);
   }

   public function addOrder(Request $request)
   {
      $data = $request->all();

      $userId = $data['user_id'];

      $rules = [
         'user_id' => 'required|integer',
      ];

      $validator = Validator::make($data,$rules);


      if($validator->fails()){
         return response()->json([
            'success' => false,
            'message' => 'user_id is not valid',
         ]);
      }


      $cartItems = CartItem::where('user_id', $userId)->get();
      if($cartItems){
         foreach ($cartItems as $item) {
            $productId = $item->product->id;
         }
      }
      $totalPrice = $cartItems->sum(function($item) {
         $product = Product::find($item->product_id); // Assuming you have a Product model and it's related by product_id
         return $item->quantity * ($product ? $product->price : 0); // Ensure price is valid
     });
      // create new Order 

      $order = new Order();
      $order->user_id = $userId;
      $order->order_number = 'ORD-' . strtoupper(uniqid()); 
      $order->total = $totalPrice;
      $order->status = 'pending';
      $order->save();

      foreach ($cartItems as $item) {
         $order->products()->attach($item->product_id, ['quantity' => $item->quantity]);
      }

      CartItem::where('user_id', $userId)->delete();
  
      if($order){
         $orderNumber = $order->number;
         $redirectUrl = route('order.placed',[ 'order_number'=> $orderNumber]);
      }


      
      return response()->json([
         'success' => true,
         'message' => 'order placed successfully',
         'redirect_url' => $redirectUrl,
      ]);
   }
}
