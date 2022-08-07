<?php

namespace App\Jobs;

use App\Mail\OrderCustomerProductListMailable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class OrderCustomerProductListMailJobQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $userInfos;
    private $domainName;
    private $order;
    private $paymentMethod;
    private $cartItems;
    private $coupon;
    private $configurationData;
    private $toMail;

    public function __construct($toMail ,$domainName, $paymentMethod, $order, $userInfos, $cartItems, $coupon, $configurationData)
    {

        $this->userInfos = $userInfos;
        $this->domainName = $domainName;
        $this->paymentMethod = $paymentMethod;
        $this->order = $order;
        $this->cartItems = $cartItems;
        $this->coupon = $coupon;
        $this->configurationData = $configurationData;
        $this->toMail = $toMail;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        Mail::to($this->toMail)->send(new OrderCustomerProductListMailable($this->domainName, $this->paymentMethod, $this->order, $this->userInfos, $this->cartItems, $this->coupon, $this->configurationData));
    }
}
