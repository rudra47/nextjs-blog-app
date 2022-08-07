<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface CartRepositoryInterface
{
    // public function getCartsInfo($request);
    public function getCartProducts($request);
    public function couponIsApplicableCheck($cart_collects);
    public function totalProductAndPackagePriceCalculate($cart_collects, $productIsApplicableForCoupon);

}
