<?php

namespace App\Services\Seller;

use App\Exceptions\AppError;
use App\Models\Product;
use App\Models\Seller;
use App\Traits\CheckProductOwner;

class DeleteProductService
{
    use CheckProductOwner;

    /**
     * Execute the service
     * 
     * @param  Seller                   $seller
     * @param  Product                  $product
     * @throws AppError
     */
    public function execute(Seller $seller, Product $product): void
    {
        $this->checkProductOwner($seller, $product);
        $product->delete();
    }
}
