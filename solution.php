<?php

require_once 'app/bootstrap.php';

use Notebooks\Cart;
use Notebooks\Coupon\CouponFactoryMethod;
use Notebooks\Product;

$productsToAdd    = [];
$productsToRemove = [];

$productsToAddString    = $argv[1];
$productsToRemoveString = $argv[2];
$coupon                 = $argv[3];

if (!empty($productsToAddString)) {
    $productsToAdd = explode(',', $productsToAddString);
}
if (!empty($productsToRemoveString)) {
    $productsToRemove = explode(',', $productsToRemoveString);
}

$availableProducts = json_decode(file_get_contents('fixtures/products.json'));
$availableCoupons  = json_decode(file_get_contents('fixtures/coupons.json'));

$cart = new Cart();

if (empty($productsToAdd)) {
    echo 'Cart is empty' . PHP_EOL;

    return;
}

foreach ($productsToAdd as $index) {
    if (!isset($availableProducts->products[$index])) {
        continue;
    }

    $productInfo = $availableProducts->products[$index];

    $product = new Product();
    $product->setId($productInfo->id);
    $product->setDescription($productInfo->description);
    $product->setPrice($productInfo->price);
    $product->setQuantity($productInfo->quantity);
    $product->setTax($productInfo->tax);

    $cart->addProduct($product);
}

foreach ($productsToRemove as $index) {
    $cart->removeProduct($index);
}

if (isset($availableCoupons->coupons[$coupon])) {
    $couponInfo = $availableCoupons->coupons[$coupon];

    $coupon = CouponFactoryMethod::makeCoupon($couponInfo->type);
    $coupon->setId($couponInfo->id);
    $coupon->setAmount($couponInfo->amount);
    $coupon->setType($couponInfo->type);

    $cart->addCoupon($coupon);
}

$cart->calculateTotal();
$cart->printCalculation();
