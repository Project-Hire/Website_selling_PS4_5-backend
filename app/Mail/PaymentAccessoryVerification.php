<?php

namespace App\Mail;

use App\Models\PaymentAccessory;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentAccessoryVerification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $paymentAccessory;
    public function __construct(PaymentAccessory $paymentAccessory)
    {
        $this->paymentAccessory=$paymentAccessory;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->markdown('email.paymentAccessory')->with(['payment'=>$this->paymentAccessory->money, 'user' => $this->paymentAccessory->user, 'accessory' => $this->paymentAccessory->accessory]);
    }
}
