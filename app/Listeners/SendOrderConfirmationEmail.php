<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail; // Import the Mail facade
use App\Mail\OrderConfirmation; // Import your mailable class
use App\Events\OrderPlaced; // Import the event class

class SendOrderConfirmationEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderPlaced $event): void
    {
        $order = $event->order;
        
        // Send the email using a mailable class
        Mail::to($order->email)->send(new OrderConfirmation($order));
    }
}
