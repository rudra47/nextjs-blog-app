<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Interfaces\ConditionalMoneyReceiverRepositoryInterface;
use Illuminate\Http\Request;

class ConditionalMoneyReceiverController extends Controller
{

    public function conditionalMoneyReceiverAlive(ConditionalMoneyReceiverRepositoryInterface $ConditionalMonyReciveRepo){
        return $ConditionalMonyReciveRepo->conditionalMoneyReceiverAlive();
    }
}
