<?php

namespace Notebooks;

use Notebooks\Coupon\Coupon;

class Cart
{
    const LINE_HEADER      = 'Product ID | Description | Quantity | Unit Net Price | Unit Gross Price | Total Gross Price';

    const LINE_PRODUCT     = '%d | %s | %s | %.2f | %.2f | %.2f';

    const LINE_SUB_TOTAL   = 'Sub Total | %.2f';

    const LINE_TOTAL_TAX   = 'Total Tax | %.2f';

    const LINE_COUPON      = 'Coupon | -%.2f';

    const LINE_GRAND_TOTAL = 'Grand Total | %.2f';

    /**
     * @var Product[]
     */
    protected $products = [];

    /**
     * @var Coupon
     */
    protected $coupon;

    /**
     * @var array
     */
    protected $output = [];

    /**
     * @param Product $product
     */
    public function addProduct(Product $product)
    {
        $this->products[] = $product;
    }

    /**
     * @param int $index
     */
    public function removeProduct($index)
    {
        unset($this->products[$index]);
    }

    /**
     * @param Coupon $coupon
     */
    public function addCoupon(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    public function calculateTotal()
    {
        $subTotal     = 0.00;
        $totalTax     = 0.00;
        $couponAmount = 0.00;

        foreach ($this->products as $product) {

            $netPrice       = $this->calculateNetPrice($product->getPrice(), $product->getTax());
            $grossLineTotal = $this->calculateGrossLineTotal($product->getPrice(), $product->getQuantity());
            $taxLineTotal   = $this->calculateTaxLineTotal($product->getPrice(), $netPrice, $product->getQuantity());

            $subTotal += $grossLineTotal;
            $totalTax += $taxLineTotal;

            $this->output[] = sprintf(
                static::LINE_PRODUCT,
                $product->getId(),
                $product->getDescription(),
                $product->getQuantity(),
                $netPrice,
                $product->getPrice(),
                $grossLineTotal
            );
        }

        if ($this->coupon) {
            $couponAmount = $this->coupon->calculateAmount($subTotal);
        }

        $total = $subTotal - $couponAmount;

        $this->output[] = sprintf(
            static::LINE_SUB_TOTAL,
            $subTotal
        );

        $this->output[] = sprintf(
            static::LINE_TOTAL_TAX,
            $totalTax
        );

        $this->output[] = sprintf(
            static::LINE_COUPON,
            $couponAmount
        );

        $this->output[] = sprintf(
            static::LINE_GRAND_TOTAL,
            $total
        );
    }

    /**
     * @param float $price
     * @param float $netPrice
     * @param int   $quantity
     *
     * @return float
     */
    protected function calculateTaxLineTotal(float $price, float $netPrice, int $quantity)
    {
        $taxAmount = ($price - $netPrice) * $quantity;

        return (float)number_format($taxAmount, 2, '.', '');
    }

    /**
     * @param float $price
     * @param int   $quantity
     *
     * @return float
     */
    protected function calculateGrossLineTotal(float $price, int $quantity)
    {
        $lineTotal = $price * $quantity;

        return (float)number_format($lineTotal, 2, '.', '');
    }

    /**
     * @param float $price
     * @param float $tax
     *
     * @return float
     */
    protected function calculateNetPrice(float $price, float $tax)
    {
        $taxFactor = 1 + $tax / 100;
        $netPrice  = $price / $taxFactor;

        return $netPrice;
    }

    public function printCalculation()
    {
        echo static::LINE_HEADER . PHP_EOL;

        foreach ($this->output as $line) {
            echo $line . PHP_EOL;
        }
    }
}
