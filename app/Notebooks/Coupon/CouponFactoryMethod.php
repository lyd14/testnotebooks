<?php

namespace Notebooks\Coupon;

class CouponFactoryMethod
{
    /**
     * @param string $type
     *
     * @return Coupon
     */
    public static function makeCoupon(string $type)
    {
        switch ($type) {
            case 'fixed':
                $coupon = new FixedCoupon();
                break;
            case 'percentage':
                $coupon = new PercentageCoupon();
                break;
            default:
                $coupon = new FixedCoupon();
                break;
        }

        return $coupon;
    }
}
