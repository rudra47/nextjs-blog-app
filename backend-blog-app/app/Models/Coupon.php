<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    const STATUS_ACTIVE         = 'active';
    const STATUS_INACTIVE       = 'inactive';
    const DISCOUNT_PERCENTAGE   = 'percentage';
    const DISCOUNT_FIXED_AMOUNT = 'fixed amount';
    const TYPE_ONE_TIME_USE     = 'one time use';
    const TYPE_UNLIMITED_USE    = 'unlimited use';
    const TYPE_USE_LIMIT        = 'use limit';

    protected $fillable = ['code', 'coupon_type', 'limit', 'discount_type', 'discount_amount', 'minimum_amount', 'used', 'valid_from', 'valid_to', 'status'];

    public function categories() {
        return $this->belongsToMany(Category::class);
    }

}
