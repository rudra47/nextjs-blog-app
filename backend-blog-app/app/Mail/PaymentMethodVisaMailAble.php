<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentMethodVisaMailAble extends Mailable
{
    use Queueable, SerializesModels;
    private $orderCreate;
    private $userInfo;
    private $visaDetails;
    private $grandTotal;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($orderCreate, $userInfo, $visaDetails, $grandTotal)
    {
        $this->orderCreate = $orderCreate;
        $this->userInfo = $userInfo;
        $this->visaDetails = $visaDetails;
        $this->grandTotal = $grandTotal;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $subject = "Monster Gear Order #".$this->orderCreate->order_no;
        return $this->view('emails.orders.visa_mail_send')
        ->with(
            ['order'=>$this->orderCreate,
            'userInfo'=> $this->userInfo,
            'visaDetails'=>$this->visaDetails,
            'grandTotal'=>$this->grandTotal
            ]
            )
        ->from('info@mymonsterlabs.com')
        ->subject($subject);

        // return $this->view('welcome');
    }
}
