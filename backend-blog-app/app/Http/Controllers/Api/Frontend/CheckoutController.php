<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Interfaces\CartRepositoryInterface;
use App\Services\Checkout\CheckoutService;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Frontend\ConfigurationController;
use App\Http\Requests\Order\OrderSubmitRequest;
use App\Interfaces\OrderRepositoryInterface;
use App\Repositories\OrderRepository;
use App\Repositories\PaymentMethodRepository;
use App\Services\Cart\CartService;


class CheckoutController extends Controller
{
    protected $paymentMethodRepository;
    protected $orderRepository;
    public function __construct()
    {
        $this->paymentMethodRepository = new PaymentMethodRepository();
        $this->orderRepository = new OrderRepository();
    }

    public function checkoutProductInfo(Request $request, CartRepositoryInterface $cartRepository,ConfigurationController $config, CheckoutService $checkoutService, CartService $cartService ){

        $cartResponse = $cartService->getCartsInfo($request);
        if( $cartResponse->original['status'] == 'success' ){

            $cart_collects =  $cartResponse->original['cartCollection'];

            $productIsApplicableForCoupon = false;
            $productIsApplicableForCoupon = $checkoutService->couponIsApplicableCheck($cart_collects);
            $totalPrice = $checkoutService->totalProductAndPackagePriceCalculate($cart_collects, $productIsApplicableForCoupon);
            $grandTotal = $totalPrice;

            // $configuration = $config->index()->original['data'];
            $configuration = $config->index();
            $configurationData = null;
            $shippingCharge = 0;
            //config wise total price calculate
            if($configuration->original['status'] == 'success'){
                $configurationData = $configuration->original['data'];
                if($totalPrice < $configurationData['min_order_amount']){
                    return response()->json([
                        'status' => 'error'
                    ]);
                }
                if($totalPrice < $configurationData['avoid_shipping_charge_for']){
                    $grandTotal = $grandTotal +  $configurationData['shipping_charge'];
                    $shippingCharge = $configurationData['shipping_charge'];
                }
            }
            $payMentMethodOfferMessage = null;
            if(isset($request->payment_method)){
                  // in checkout page payment method sort_name wise payment data fetch
                $paymentMethod  =   $this->paymentMethodRepository->getActivePaymentMethodByShortName($request->payment_method);
                $grandTotal = $this->orderRepository->paymentMethodWiseGrandTotalCalculate($paymentMethod, $totalPrice, $grandTotal, $productIsApplicableForCoupon);

                if(!is_null($paymentMethod->surcharge)){
                    $payMentMethodOfferMessage = "( $".$paymentMethod->surcharge." surcharge on ".$paymentMethod->name." payment )";

                }else if(!is_null($paymentMethod->discount_type) && strtolower($paymentMethod->discount_type) == "percentage"){
                    $payMentMethodOfferMessage = " ( ".$paymentMethod->discount_amount ."% discount on  ". $paymentMethod->name." payment)";
                }
                else if(!is_null($paymentMethod->discount_type) && strtolower($paymentMethod->discount_type) == "dollar"){
                    $payMentMethodOfferMessage = " ( $".$paymentMethod->discount_amount ." discount on  ". $paymentMethod->name." payment)";
                }

            }
            // for get all active payment method with money_receiver_wise, we make money_receiver_wise request true
//            $request['money_receiver_wise'] = true;
            $requestPeymentMethod = $request->payment_method;
            $activePaymentMethods = $this->paymentMethodRepository->getAllActivePaymentMethod();

            $paymentHtml = view("frontend.checkout.input-peyment-method",compact('activePaymentMethods','grandTotal','requestPeymentMethod'))->render();

            // make reusable cart product in array
            $cartItemsArray = array();
            $cartItems = $this->orderRepository->cartWiseProductAndPackageMakeListWithStoreForSellIsOptional($cartItemsArray ,$cart_collects, $productIsApplicableForCoupon, null );

            $html = view('frontend.checkout.checkout-right-side', compact(
                    'cartItems',
                    'productIsApplicableForCoupon',
                    'totalPrice','grandTotal','shippingCharge','payMentMethodOfferMessage'
                ))->render();
            return response()->json([
                'status' => 'success',
                'html' => $html,
                'paymentHtml' => $paymentHtml
            ]);
        }

    }



    public function orderStore(OrderSubmitRequest $request, OrderRepositoryInterface $orderRepository)
    {
        return $orderRepository->orderStore($request);
    }






}
