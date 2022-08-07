<?php

namespace App\Jobs;

use App\Mail\PaymentMethodMailSend;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class PaymentMethodMailSendJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private $grandTotal;
    private $template_name;
    private $moneyReceiver;
    private $domainName;
    private $paymentMethod;
    private $orderCreate;
    private $toEmail;

    public function __construct($toEmail ,$template_name, $grandTotal, $moneyReceiver, $domainName, $paymentMethod, $orderCreate)
    {

        $this->toEmail = $toEmail;
        $this->grandTotal = $grandTotal;
        $this->template_name = $template_name;
        $this->moneyReceiver = $moneyReceiver;
        $this->domainName = $domainName;
        $this->paymentMethod = $paymentMethod;
        $this->orderCreate = $orderCreate;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->toEmail)->send(new PaymentMethodMailSend($this->template_name, $this->grandTotal, $this->moneyReceiver, $this->domainName, $this->paymentMethod, $this->orderCreate));
    }
}
