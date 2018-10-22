<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Order;
use App\Customer;
use App\Menu;

class SendEmailCustomerMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $customer;
    public $menu;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, Customer $customer , Menu $menu)
    {
        //
        $this->order = $order;
        $this->customer = $customer;
        $this->menu = $menu;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@ecworkshop.vn','EC Distribution')
                    ->subject('Xác nhận đơn hàng')
                    ->view('emails.notify');
    }
}
