<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;
use App\Order;
use App\Customer;
use App\Menu;
use App\Mail\SendEmailCustomerMailable;

class SendEmailCustomerOrdersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    protected $customer;
    protected $menu;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order, Customer $customer, Menu $menu)
    {
        //
        $this->order = $order;
        $this->customer = $customer;
        $this->menu = $menu;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Mail::to($this->customer->email, $this->customer->name)->send(new SendEmailMailable($this->order, $this->customer, $this->menu));
    }
}

