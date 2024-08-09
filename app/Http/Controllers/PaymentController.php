<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;

class PaymentController extends Controller
{


    public function payment(Request $request)
    {
        // Create an order
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $order  = $api->order->create(array(
            'amount'          => $request->amount * 100, // amount in the smallest currency unit
            'currency'        => 'INR',
            'receipt'         => 'order_rcptid_' . time(),
            'payment_capture' => 1 // Capture the payment immediately
        ));
        return view('payment', compact('order'));
    }




    public function payment_success(Request $request)
    {
        // Handle successful payment
        return 'Payment successful';
    }




    public function payment_failure(Request $request)
    {
        // Handle failed payment
        return 'Payment failed';
    }
}
