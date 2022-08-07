<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentMethodMailSend extends Mailable
{
    use Queueable, SerializesModels;


    private $grandTotal;
    private $template_name;
    private $moneyReceiver;
    private $domainName;
    private $paymentMethod;
    private $orderCreate;

    public function __construct($template_name, $grandTotal, $moneyReceiver, $domainName, $paymentMethod, $orderCreate)
    {

        $this->grandTotal = $grandTotal;
        $this->template_name = $template_name;
        $this->moneyReceiver = $moneyReceiver;
        $this->domainName = $domainName;
        $this->paymentMethod = $paymentMethod;
        $this->orderCreate = $orderCreate;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // $subject = "Monster Gear Order #".$this->orderCreate->order_no;
        $subject = "Monster Gear Order [".$this->paymentMethod->short_name."] #".$this->orderCreate->order_no;
        return $this->view($this->template_name)
        ->with(
            [

            'grandTotal'=>$this->grandTotal,
            'moneyReceiver'=>$this->moneyReceiver,
            'domainName'=>$this->domainName,

            ]
            )
        ->from('info@mymonsterlabs.com', 'Monster Labs')
        ->subject($subject);
        // return $this->view('welcome');
    }
}
