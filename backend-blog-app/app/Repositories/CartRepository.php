<?php

namespace App\Repositories;

use App\Interfaces\CartRepositoryInterface;
use App\Models\Coupon;
use App\Models\Package;
use App\Models\Product;
use App\Services\Cart\CartService;
use App\Services\Checkout\CheckoutService;
use App\Services\Coupon\CouponService;
use Illuminate\Support\Carbon;


class CartRepository implements CartRepositoryInterface
{
    protected $cartService;
    protected $checkoutService;
    protected $couponService;
    public function __construct(){
        $this->cartService = new CartService();
        $this->checkoutService = new CheckoutService();
        $this->couponService = new CouponService();
    }

    public function getCartProducts($request){
        $cart_collect = $this->cartService->getCartsInfo($request);
        return response()->json([
            'carts' => $cart_collect
        ]);
    }
    public function couponIsApplicableCheck($cart_collects){
        return $this->checkoutService->couponIsApplicableCheck($cart_collects);
    }

    public function totalProductAndPackagePriceCalculate($cart_collects, $productIsApplicableForCoupon){
        return $this->checkoutService->totalProductAndPackagePriceCalculate($cart_collects, $productIsApplicableForCoupon);
    }


}
