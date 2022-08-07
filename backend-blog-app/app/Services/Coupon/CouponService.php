<?php
namespace App\Services\Coupon;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;

class CouponService{

    public function couponCodeValidaitonCheck($coupon){
        $today = Carbon::today()->format('Y-m-d');

        // coupon code is not exist
        if(is_null($coupon)){
            return response()->json([
                'status' => 'error',
                'message' => "Invalid discount code. Please re-enter the discount code. "
            ]);
        }
        // coupon validity check
        if(strtotime($today) < strtotime($coupon->valid_from) || strtotime($today) > strtotime($coupon->valid_to) ){
            return response()->json([
                'status' => 'error',
                'message' => "This coupon code already expired. Please re-enter the valide discount code."
            ]);
        }

        if($coupon->coupon_type == Coupon::TYPE_USE_LIMIT){
            // one time validation code
            if($coupon->limit <= 0){
                return response()->json([
                    'status' => 'error',
                    'message' => "This coupon code limit is over. Please re-enter the valide discount code."
                ]);
            }
        }
    }

    public function onTimeCouponValidationCheck($couponCode, $email ){
        if(isset($couponCode) && !is_null($couponCode)){
            $user = User::where('email',$email)->first();
            if(!is_null($user)){
                //on time user
                $couponData = Coupon::where('code',$couponCode)->where('coupon_type',Coupon::TYPE_ONE_TIME_USE)->first();
                if(!is_null( $couponData )){
                    $orderDataExist = Order::where(function($query) use($user, $couponData){
                        $query->where("user_id",$user->id)->where('coupon_id',$couponData->id);
                    })->exists();
                    if( $orderDataExist ){
                        return response()->json([
                            'status' => 'ontimeuse_coupon_error',
                            'message' => 'You already used this coupon.'
                        ]);
                    }
                }
            }
        }
    }

}
