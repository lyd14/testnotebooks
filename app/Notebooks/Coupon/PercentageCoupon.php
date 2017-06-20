<?php

namespace Notebooks\Coupon;

class PercentageCoupon extends Coupon
{
    /**
     * @param float $total
     *
     * @return float
     */
    public function calculateAmount(float $total)
    {
        $couponAmount = $this->getAmount() / 100 * $total;
        $difference   = $total - $couponAmount;

        if ($difference < 0) {
            return $total;
        }

        return (float)number_format($couponAmount, 2, '.', '');
    }
}
