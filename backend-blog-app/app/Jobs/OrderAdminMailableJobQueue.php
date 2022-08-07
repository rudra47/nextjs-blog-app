<?php

namespace App\Jobs;

use App\Mail\OrderAdminMailable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class OrderAdminMailableJobQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        Mail::to($this->data['email'])->send(new OrderAdminMailable($this->data ,$this->domainName, $this->paymentMethod, $this->order, $this->userInfos, $this->cartItems, $this->coupon, $this->configurationData, $this->visaDetails));
    }
}
