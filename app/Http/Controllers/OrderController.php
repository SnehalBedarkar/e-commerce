<?php

namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::all();
        return view('Order.order',compact('orders'));
    }

    public function create(Request $request , string $id){

        // authenticate user 
        $user = Auth::user();

        // find the product by provided id 

        $product = Product::find($id);

        if($product){
            $order = new Order();
            $order->user_id = $user->id;
            $order->product_id = $product->id;
            $order->quantity = 1;
            $order->status = 'pending';
            $order->save();
    
            return  response()->json([
                'success' => true,
                'message' => 'order created successfully',
                'redirect_url' => route('order.show')
            ]); 
        }else{
            return response()->json([
                'success' => true,
                'product' => $product,
            ],404);
        }
    }



}
