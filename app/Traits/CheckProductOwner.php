<?php

namespace App\Traits;

use App\Exceptions\AppError;
use App\Models\Product;
use App\Models\Seller;

trait CheckProductOwner
{
    /**
     * Method that checks if the current seller is the owner of the product
     * 
     * @param  Seller  $seller
     * @param  Product  $product
     * @throws AppError
     */
    protected function checkProductOwner(Seller $seller, Product $product) : void
    {
        if ($seller->id != $product->seller_id) {
            throw new AppError('The informed seller is not the product owner', 422);
        }
    }
}