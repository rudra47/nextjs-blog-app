<?php

namespace App\Repositories;

use App\Interfaces\CouponRepositoryInterface;
use App\Models\Coupon;
use Illuminate\Support\Str;
use DB;

class CouponRepository implements CouponRepositoryInterface {
    public function getAllCoupon() {
        return Coupon::latest()->get();
    }

    public function getCouponById($id) {
        return Coupon::findOrFail($id);
    }

    public function deleteCoupon($id) {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();
        return $coupon;
    }

    public function createCoupon($request) {
        DB::beginTransaction();
        $coupon = Coupon::create([
            'code'            => $request->code, 
            'coupon_type'     => $request->coupon_type, 
            'limit'           => $request->limit, 
            'discount_type'   => $request->discount_type, 
            'discount_amount' => $request->discount_amount, 
            'minimum_amount'  => $request->minimum_amount, 
            'valid_from'      => $request->valid_from, 
            'valid_to'        => $request->valid_to, 
            'status'          => $request->status
        ]);

        if($request->category_ids) {
            $coupon->categories()->sync($request->category_ids);
        }
        DB::commit();

        return $coupon;
    }

    public function updateCoupon($coupon, $request) {
        $coupon->code            = $request->code;
        $coupon->coupon_type     = $request->coupon_type;
        $coupon->limit           = $request->limit;
        $coupon->discount_type   = $request->discount_type;
        $coupon->discount_amount = $request->discount_amount;
        $coupon->minimum_amount  = $request->minimum_amount;
        $coupon->valid_from      = $request->valid_from;
        $coupon->valid_to        = $request->valid_to;
        $coupon->status          = $request->status;
        $coupon->save();

        if($request->category_ids) {
            $coupon->categories()->sync($request->category_ids);
        }

        return $coupon;
    }
}
