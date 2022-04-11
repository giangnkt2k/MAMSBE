<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BillEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $detail;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($detail)
    {
        $this->detail = $detail;
        $invoice_component = json_decode($detail->bill->invoice_component);
        $this->detail->invoice_component = $invoice_component;
        $this->detail->invoice_component->service_price = $invoice_component->service_price;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Bill monthly")->view('email.bill');
    }
}
