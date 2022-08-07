<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCustomerProductListMailable extends Mailable
{
    use Queueable, SerializesModels;

    private $userInfos;
    private $domainName;
    private $order;
    private $paymentMethod;
    private $cartItems;
    private $coupon;
    private $configurationData;

    public function __construct($domainName, $paymentMethod, $order, $userInfos, $cartItems, $coupon, $configurationData)
    {

        $this->userInfos = $userInfos;
        $this->domainName = $domainName;
        $this->paymentMethod = $paymentMethod;
        $this->order = $order;
        $this->cartItems = $cartItems;
        $this->coupon = $coupon;
        $this->configurationData = $configurationData;

    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Your Monster Labs Order Details";
        return $this->view("emails.orders.order_customer_mail_send")
        ->with(
            [

            'userInfos'=>$this->userInfos,
            'domainName'=>$this->domainName,
            'paymentMethod'=>$this->paymentMethod,
            'order'=>$this->order,
            'cartItems'=>$this->cartItems,
            'coupon'=>$this->coupon,
            'configurationData'=>$this->configurationData,

            ]
            )
        ->from('info@mymonsterlabs.com', 'Monster Labs')
        ->subject($subject);
    }
}
