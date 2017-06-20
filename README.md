ASSIGNMENT
========================

Please run the solution by calling
php solution.php "0,1,2" "1" 1

Task Description
-------------------

Implement a basket solution for NBB in 2-3h
Example: I want to change the basket with "add to/remove from basket"-method or update quantities. I want to use either a 20% coupon or a cash-coupon (f.e. 20€) to pay less. I need the basket total sum including net/gross informations, ideally per position.
Needed functionality:
addProduct to basket
removeProduct
addCoupon
you are only allowed to add one coupon
calcTotal
gross
tax
net
Please do not use any DB and do not create any user interface. Just pure PHP code is sufficient, must be able to show the functionality with different cases. Try to implement the code as clean as possible!

Arguments
--------------

  * Argument 1: list of products to add

  * Argument 2: list of products to remove

  * Argument 3: coupon to use


Requirements
--------------

  * PHP7

  * run composer install

Next steps
--------------

  * Improve validation for arguments

  * Improve error handling

  * Optimise processing for large data sets

  * Use framework

  * Add tests
