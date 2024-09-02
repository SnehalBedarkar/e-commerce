<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope; // Correct import for Envelope
use Illuminate\Mail\Mailables\Content;  // Correct import for Content
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class OrderPlacedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Placed Mail',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'Emails.order_placed',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
