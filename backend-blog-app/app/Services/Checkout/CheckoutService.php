<?php
namespace App\Services\Checkout;

class CheckoutService{
    public function freeProductQuantityCalculate($cart){
        $freeOfferProduct = $cart->offers[0]['offer'];
        $calQuantiry = floor( $cart['quantity'] / $cart->offers[0]['buy_quantity'] );
        $offerAbleProduct = $calQuantiry * $freeOfferProduct;
        return $offerAbleProduct; // number 1 /2 / 3
    }
    public function freeProduct($cart){
        if(count($cart->offers) > 0){
            if($cart['cartType'] == 'product'){
                if($cart->offers[0]['offer_type'] == 'buy_and_get'){
                    if($cart->offers[0]['offer_variation'] == 'free_product' && count($cart->offers[0]->products) > 0){
                        $free_product = $cart->offers[0]->products[0];
                        $free_product_name = $free_product['name'];
                        if( (int)$this->freeProductQuantityCalculate($cart) > 0 ){
                            return $free_product_name. " ( ".$this->freeProductQuantityCalculate($cart)."- items Free )";
                        }

                    }
                }
            }else  if($cart['cartType'] == 'package'){
                if($cart->offers[0]['offer_type'] == 'package'){
                    if($cart->offers[0]['offer_variation'] == 'free_product' && count($cart->offers[0]->products) > 0){
                        $free_product = $cart->offers[0]->products[0];
                        $free_product_name = $free_product['name'];
                        if( (int)$this->freeProductQuantityCalculate($cart) > 0 ){
                            return $free_product_name. " ( ".$this->freeProductQuantityCalculate($cart)."- items Free )";
                        }

                    }
                }
            }
        }
        return false;
    }
    public function freeProductForProductAndPackage($cart, $productIsApplicableForCoupon){
        if($cart['cartType'] == 'product' && !$productIsApplicableForCoupon ){
            return $this->freeProduct($cart);
        }else if($cart['cartType'] == 'package' ){
            return $this->freeProduct($cart);
        }
    }
    public function singleProductAndPackagePriceCalculate($cart){
        $price = 0;
        if(count($cart->offers) > 0){
            if((int)$cart['quantity'] >= $cart->offers[0]['buy_quantity']){

                if($cart['cartType'] == 'product'){

                    if($cart->offers[0]['offer_type'] == 'single_product'){
                        if($cart->offers[0]['discount_type'] == 'percentage'){
                            $price =  ($cart['price'] * $cart['quantity']) - ((($cart['price'] * $cart['quantity']) * $cart->offers[0]['offer']) / 100);
                            return $price;
                        }
                        // money calculate
                        $totalPrice = $cart['price'] * $cart['quantity'];
                        $moneyQtyMng = floor( $cart['quantity'] / $cart->offers[0]['buy_quantity'] );
                        $price = $totalPrice - ( $moneyQtyMng * $cart->offers[0]['offer']);
                        return $price;
                    }
                    else if($cart->offers[0]['offer_type'] == 'buy_and_get'){
                         //**** here offer_type = buy_and_get
                        // and offer_variation = 'free_product'
                        if($cart->offers[0]['offer_variation'] == 'free_product'){
                            return $cart['quantity'] * $cart['price'];
                        }
                        // offer_variation == discount_product
                        if($cart->offers[0]['discount_type'] == 'percentage'){
                            $price =  ($cart['price'] * $cart['quantity']) - ((($cart['price'] * $cart['quantity']) * $cart->offers[0]['offer']) / 100);
                            return $price;
                        }
                        // money calculate
                        $totalPrice = $cart['price'] * $cart['quantity'];
                        $moneyQtyMng = floor( $cart['quantity'] / $cart->offers[0]['buy_quantity'] );
                        $price = $totalPrice - ( $moneyQtyMng * $cart->offers[0]['offer']);
                        return $price;
                    }


                }
                else if($cart['cartType'] == 'package'){
                     // and offer_variation = 'free_product'
                     if($cart->offers[0]['offer_variation'] == 'free_product'){
                        return $cart['quantity'] * $cart['price'];
                    }
                    // offer_variation == discount_product
                    if($cart->offers[0]['discount_type'] == 'percentage'){
                        $price =  ($cart['price'] * $cart['quantity']) - ((($cart['price'] * $cart['quantity']) * $cart->offers[0]['offer']) / 100);
                        return $price;
                    }
                    // money calculate
                    $totalPrice = $cart['price'] * $cart['quantity'];
                    $moneyQtyMng = floor( $cart['quantity'] / $cart->offers[0]['buy_quantity'] );
                    $price = $totalPrice - ( $moneyQtyMng * $cart->offers[0]['offer']);
                    return $price;
                }

            }else{
                return $cart['price'] * $cart['quantity'];
            }
        }else{
            return $cart['price'] * $cart['quantity'];
        }

    }

    public function totalProductAndPackagePriceCalculate($cart_collects, $productIsApplicableForCoupon){
        $couponTotalPrice = 0;
        $coupon = null;
        $couponDiscountPrice = 0;
        $price = 0;
        $totalPrice = 0;
        if(count($cart_collects) > 0){

            if($productIsApplicableForCoupon){
                foreach($cart_collects as $cart_collect){
                    if($cart_collect['cartType'] == 'product' && $cart_collect['activeCoupon'] == true ){
                        $coupon = $cart_collect->coupon;
                        $couponTotalPrice = $couponTotalPrice + ( $cart_collect['price'] * $cart_collect['quantity'] );
                    }
                }

                $couponDiscountPrice = $coupon['discount_type'] == 'percentage' ? (($couponTotalPrice * $coupon['discount_amount'])/100) : ($couponTotalPrice -  $coupon['discount_amount']);
               ;

                $couponTotalPrice = $couponTotalPrice - $couponDiscountPrice;


                foreach($cart_collects as $cart_collect){
                    if($cart_collect['activeCoupon'] == false ){
                        $price = $price + $this->singleProductAndPackagePriceCalculate($cart_collect);
                    }
                }

                $totalPrice = $couponTotalPrice + $price;
                return $totalPrice;
            }else{
                foreach($cart_collects as $cart_collect){
                    $price = $price + $this->singleProductAndPackagePriceCalculate($cart_collect);
                }
                $totalPrice = $price;
                return $totalPrice;
            }

        }
    }

    public function couponIsApplicableCheck($cart_collects){
        $coupon = null;
        $totalPriceForCouponProduct = 0;
        $productIsApplicableForCoupon = false;
        foreach($cart_collects as $cart_collect){
            if($cart_collect['applyCoupon'] && $cart_collect['activeCoupon']){
                $coupon = $cart_collect->coupon;
                $totalPriceForCouponProduct = $totalPriceForCouponProduct + ($cart_collect['price'] * $cart_collect['quantity'] );
            }
        }
        if($coupon != null){
            if($totalPriceForCouponProduct >= $coupon['minimum_amount']){
                $productIsApplicableForCoupon = true;
            }
        }
        return $productIsApplicableForCoupon;
    }



}
