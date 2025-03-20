<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderMail extends Mailable implements ShouldQueue

{
    use Queueable, SerializesModels;

    public $order;
    public $cart;

    public function __construct($order, $cart)
    {
        $this->order = $order;
        $this->cart = $cart;
    }

    public function build()
    {
        return $this->subject('Order Confirmation : ' . $this->order->order_number)
                    ->view('emails.order'); // Menggunakan template Blade
    }
}
