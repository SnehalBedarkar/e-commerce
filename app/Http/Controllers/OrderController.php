<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class OrderController extends Controller
{

   // method for all orders

   public function index(){
      $orders = Order::all();
      return view('dashboard.orders',compact('orders'));
      // return $orders;
   }


   // method for chart of orders

   public function chartData()
   {
      // Example: Get orders and prepare chart data
      $orders = Order::all();
      
      // For simplicity, assume you are using order creation months as labels and counts as values
      $labels = $orders->groupBy(function($date) {
         return $date->created_at->format('Y-m-d'); // Group by month and year
      })->keys();

      $values = $orders->groupBy(function($date) {
         return $date->created_at->format('Y-m-d');
      })->map->count()->values();
      
      return response()->json([
         'labels' => $labels,
         'values' => $values
      ]);
   }

   // method for userspecific orders

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
  

   // method for add order 

   public function addOrder(Request $request)
   {
      $data = $request->all();

      // Define validation rules
      $rules = [
         'payment_id' => 'required|string',
         'address_id' => 'required|integer',
      ];

      // Validate request data
      $validator = Validator::make($data, $rules);
      if ($validator->fails()) {
         return response()->json([
               'success' => false,
               'message' => 'Validation failed',
               'errors' => $validator->errors()
         ]);
      }

      // Retrieve necessary data
      $paymentId = $data['payment_id'];
      $userId = Auth::id();
      $addressId = $data['address_id'];

      // Retrieve cart items for the user
      $cartItems = CartItem::where('user_id', $userId)->with('product')->get();
      if ($cartItems->isEmpty()) {
         return response()->json([
               'success' => false,
               'message' => 'No items found in cart'
         ]);
      }

      // Calculate total price of cart items
      $totalPrice = $cartItems->sum(function ($item) {
         return $item->quantity * $item->product->price; // Using relationship to get product price
      });

      // Create new Order
      $order = new Order();
      $order->user_id = $userId;
      $order->order_number = 'ORD-' . strtoupper(uniqid()); 
      $order->total = $totalPrice;
      $order->razorpay_payment_id = $paymentId;
      $order->address_id = $addressId;
      $order->status = 'pending';
      $order->save();

      // Attach products to the order
      foreach ($cartItems as $item) {
         $order->products()->attach($item->product_id, ['quantity' => $item->quantity]);
      }

      // Clear the cart
      CartItem::where('user_id', $userId)->delete();

      // Set session flash data
      session()->flash('order_id', $order->id);

      // Return success response
      return response()->json([
         'success' => true,
         'message' => 'Order created successfully',
         'redirect_url' => '/order/placed',
      ]);
   }



   
   public function orderPlaced()
   {
      $orderId = session('order_id');
      $order = Order::find($orderId);
      return view('home.order_place', compact('order'));
   }



   public function orderDestroy(Request $request){
      $data = $request->all();

      $rules = [
         'order_id' => 'required|integer',
      ];

      $orderId = $data['order_id'];

      $order = Order::find($orderId);
      if($order){
         $order->delete();
         return response()->json([
            'success' => true,
            'message' => 'order deleted successfully'
         ]);
      }else{
         return response()->json([
            'success' => false,
            'message' => 'order not found'
         ]);
      }

   }
}
