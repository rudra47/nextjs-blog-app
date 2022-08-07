<?php
namespace App\Services\Cart;

use App\Models\Coupon;
use App\Models\Package;
use App\Models\Product;
use App\Services\Coupon\CouponService;

class CartService{
    protected $couponService;
    public function __construct()
    {
        $this->couponService = new CouponService;
    }

    public function couponWiseProducts($coupon){

        $coupon_wise_products = $coupon->load(['categories.products'=>function($query){
            $query->select('id','name','price','image');
        }]);
        $coupon_wise_products_coll = collect([]);
        //coupon wise cart product find in array
        if(count($coupon_wise_products->categories) > 0){
            foreach($coupon_wise_products->categories as $category){
                if(count( $category->products->pluck('id')->toArray()) > 0){
                    $coupon_wise_products_coll->push( $category->products->pluck('id')->toArray());
                }
            }
        }
        // $coupon = Coupon::select(['id','code','coupon_type','limit','discount_type','discount_amount','minimum_amount'])->where('code',$coupon->code)->where('status','active')->first();
        $coupon_products = count($coupon_wise_products_coll) > 0 ? $coupon_wise_products_coll->collapse()->unique()->toArray() :array() ;
        return $coupon_products;
    }

    public function prodcutAndPackageCouponApply($carts, $coupon){
        $cart_collect = collect([]);
        $couponProductsInArray = $this->couponWiseProducts($coupon);
        foreach($carts as $cart){
            if($cart['cartType'] == 'product'){
                $item = Product::select(['id','name','slug','price','image'])->find($cart['id']);
                if(!is_null($item)){
                    if( in_array( $item->id, $couponProductsInArray) ){
                        $item->load(['offers','offers.products'=>function($query){
                            $query->select('id','name','price','image','status');
                        }])->toArray();
                            $item['quantity'] = $cart['quantity'];
                            $item['cartType'] = $cart['cartType'];
                            $item['activeCoupon'] = true;
                            $item['applyCoupon'] = true;
                            $item['coupunCode'] = $coupon->code;
                            $item['coupon'] = $coupon->toArray();
                            $cart_collect->push($item);
                    }else{
                        $item->load(['offers','offers.products'=>function($query){
                            $query->select('id','name','price','image','status');
                        }])->toArray();
                        $item['quantity'] = $cart['quantity'];
                        $item['cartType'] = $cart['cartType'];
                        $item['activeCoupon'] = false;
                        $item['applyCoupon'] = true;
                        $item['coupunCode'] = $coupon->code;
                        $item['coupon'] = null;
                        $cart_collect->push($item);
                    }
                }

            }else if($cart['cartType'] == 'package'){
                $item = Package::select(['id','name','slug','price','image'])->find($cart['id']);
                if(isset($item) && !empty($item)){
                    $item->load(['offers','offers.products'=>function($query){
                        $query->select('id','name','price','image','status');
                    }])->toArray();
                    $item['quantity'] = $cart['quantity'];
                    $item['cartType'] = $cart['cartType'];
                    $item['activeCoupon'] = false;
                    $item['applyCoupon'] = false;
                    $item['coupunCode'] = $coupon->code;
                    $item['coupon'] = null;
                    $cart_collect->push($item);
                }
            }
        }
        return $cart_collect;
    }

    public function prodcutAndPackageWithoutCoupon($carts){
        $cart_collect = collect([]);
        foreach($carts as $cart){
            if($cart['cartType'] == 'product'){
                $item = Product::select(['id','name','slug','price','image'])->find($cart['id']);
                if(!is_null($item)){
                    $item->load(['offers','offers.products'=>function($query){
                        $query->select('id','name','price','image','status');
                    }])->toArray();
                    $item['quantity'] = $cart['quantity'];
                    $item['cartType'] = $cart['cartType'];
                    $item['activeCoupon'] = false;
                    $item['applyCoupon'] = false;
                    $item['coupunCode'] = null;
                    $item['coupon'] = null;
                    $cart_collect->push($item);
                }

            }else if($cart['cartType'] == 'package'){
                $item = Package::select(['id','name','slug','price','image'])->find($cart['id']);
                if(isset($item) && !empty($item)){
                    $item->load(['offers','offers.products'=>function($query){
                        $query->select('id','name','price','image','status');
                    }])->toArray();
                    $item['quantity'] = $cart['quantity'];
                    $item['cartType'] = $cart['cartType'];
                    $item['activeCoupon'] = false;
                    $item['applyCoupon'] = false;
                    $item['coupunCode'] = null;
                    $item['coupon'] = null;
                    $cart_collect->push($item);
                }
            }
        }
        return $cart_collect;
    }


    public function getCartsInfo($request)
    {
        $coupon = null;
        $cart_collect = collect([]);
        if(!is_null($request->code)){

            $coupon = Coupon::where('code',$request->code)->where('status','active')->first();
            $couponValidate =  $this->couponService->couponCodeValidaitonCheck($coupon);
            if($couponValidate){
                return $couponValidate;
            }

            if(count($request->cart) > 0){
                $cart_collect = $this->prodcutAndPackageCouponApply($request->cart, $coupon);
            }
            return response()->json([
                'status' => 'success',
                'cartCollection' => $cart_collect,
            ]);

        }else{
            if(count($request->cart) > 0){
                $cart_collect = $this->prodcutAndPackageWithoutCoupon($request->cart);
            }
            // return $cart_collect;
            return response()->json([
                'status' => 'success',
                'cartCollection' => $cart_collect,
            ]);
        }
    }


}
