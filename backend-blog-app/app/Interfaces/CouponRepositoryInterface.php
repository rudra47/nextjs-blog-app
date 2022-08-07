<?php

namespace App\Interfaces;

interface CouponRepositoryInterface
{
    public function getAllCoupon();
    public function deleteCoupon($id);
    public function createCoupon($request);
    public function updateCoupon($id, $request);
    public function getCouponById($id);
}
