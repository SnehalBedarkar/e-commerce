<?php
namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Mail\OrderPlacedMail;
use Illuminate\Support\Facades\Mail;

class SendOrderPlacedEmail
{
    public function handle(OrderPlaced $event)
    {
        Mail::to($event->order->user->email)->send(new OrderPlacedMail($event->order));
    }
}
