<?php

namespace App\Services;

use App\Http\Controllers\CartController;
use App\Models\Coupon;
use Carbon\Carbon;

class CouponService
{
    public function applyCoupon($code, $product=null)
    {
        $subTotal = (new CartController())->cart_total();

        $validationResult = $this->validateCoupon($code);

        if (!$validationResult['success']) {
            return $validationResult;
        }

        $coupon = $validationResult['coupon'];
        $discount = 0;

        if ($coupon->type == 'fixed') {
            $discount = min($coupon->value, $subTotal);
        } elseif ($coupon->type == 'percent') {
            $discount = ($coupon->value / 100) * $subTotal;
        }

        $coupon->increment('used');

        return [
            'success' => true,
            'message' => 'Coupon applied successfully',
            'discount' => $discount,
            'total' => $subTotal - $discount // Adjusted total after discount
        ];
    }

    public function validateCoupon($code)
    {
        $result = [
            'success' => false,
            'coupon' => null
        ];
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon || !$coupon->status) {
            return ['success' => false, 'message' => 'Invalid coupon code'];
        }

        if ($coupon->start_date > Carbon::now() || ($coupon->end_date && $coupon->end_date < Carbon::now())) {
            return ['success' => false, 'message' => 'Coupon is not valid for the current date'];
        }

        if ($coupon->usage_limit && $coupon->used >= $coupon->usage_limit) {
            return ['success' => false, 'message' => 'Coupon usage limit reached'];
        }
        $result['success'] = true;
        $result['coupon'] = $coupon;

        return $result;
    }
}
