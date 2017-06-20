<?php

namespace Notebooks\Coupon;

class FixedCoupon extends Coupon
{
    /**
     * @param float $total
     *
     * @return float
     */
    public function calculateAmount(float $total)
    {
        $difference = $total - $this->getAmount();

        if ($difference < 0) {
            return $total;
        }

        return $this->getAmount();
    }
}
