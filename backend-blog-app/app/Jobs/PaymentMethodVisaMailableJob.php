<?php

namespace App\Jobs;

use App\Mail\PaymentMethodVisaMailAble;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class PaymentMethodVisaMailableJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $orderCreate;
    private $userInfo;
    private $visaDetails;
    private $grandTotal;
    private $toEmail;

    public function __construct($toEmail ,$orderCreate, $userInfo, $visaDetails, $grandTotal)
    {
        $this->toEmail = $toEmail;
        $this->orderCreate = $orderCreate;
        $this->userInfo = $userInfo;
        $this->visaDetails = $visaDetails;
        $this->grandTotal = $grandTotal;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->toEmail)->send(new PaymentMethodVisaMailAble($this->orderCreate, $this->userInfo, $this->visaDetails, $this->grandTotal));
    }
}
