<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Interfaces\PaymentMethodRepositoryInterface;
use Illuminate\Http\Request;
use App\Repositories\PaymentMethodRepository;

class PaymentMethodController extends Controller
{
    private $paymentMethodRepository;

    public function __construct(PaymentMethodRepositoryInterface $paymentMethodRepository)
    {
        $this->paymentMethodRepository = $paymentMethodRepository;
    }
    public function getActivePaymentMethods(){
        $activePaymentMethods  = $this->paymentMethodRepository->getAllActivePaymentMethod();
        if($activePaymentMethods->count() > 0){
            return response()->json([
                'status' => 'success',
                'activePaymentMethods' => $activePaymentMethods
            ]);
        }
        return response()->json([
            'status' => 'error'
        ]);

    }

    public function getPaymentMethodById($id){
        return response()->json([
            'data' => $this->paymentMethodRepository->getPaymentMethodById($id)
        ]);
    }
}
