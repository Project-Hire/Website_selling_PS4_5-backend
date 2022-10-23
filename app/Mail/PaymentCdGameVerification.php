<?php

namespace App\Mail;

use App\Models\PaymentCDGame;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentCdGameVerification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $paymentCDGame;
    public function __construct(PaymentCDGame $paymentCDGame)
    {
        $this->paymentCDGame=$paymentCDGame;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->markdown('email.paymentCdGame')->with(['payment'=>$this->paymentCDGame->money, 'user' => $this->paymentCDGame->user, 'cdGame' => $this->paymentCDGame->cdGame]);
    }
}
