<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderAdminMailable extends Mailable
{
    use Queueable, SerializesModels;

    private $userInfos;
    private $domainName;
    private $order;
    private $paymentMethod;
    private $cartItems;
    private $coupon;
    private $configurationData;
    private $data;
    private $visaDetails;

    public function __construct($data,$domainName, $paymentMethod, $order, $userInfos, $cartItems, $coupon, $configurationData, $visaDetails)
    {

        $this->userInfos = $userInfos;
        $this->domainName = $domainName;
        $this->paymentMethod = $paymentMethod;
        $this->order = $order;
        $this->cartItems = $cartItems;
        $this->coupon = $coupon;
        $this->configurationData = $configurationData;
        $this->data = $data;
        $this->visaDetails = $visaDetails;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = $this->data['subject'];
        return $this->view("emails.orders.order_admin_mail_send")
        ->with(
            [

            'userInfos'=>$this->userInfos,
            'domainName'=>$this->domainName,
            'paymentMethod'=>$this->paymentMethod,
            'order'=>$this->order,
            'cartItems'=>$this->cartItems,
            'coupon'=>$this->coupon,
            'configurationData'=>$this->configurationData,
            'visaDetails'=>$this->visaDetails,

            ]
            )
        ->from('info@mymonsterlabs.com', 'Monster Labs')
        ->subject($subject);
    }
}
