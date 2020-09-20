<?php

namespace App\Services\Seller;

use App\Exceptions\AppError;
use App\Http\Requests\Seller\UpdateProductRequest;
use App\Models\Product;
use App\Models\Seller;

class UpdateProductService
{
    /**
     * Execute the service
     * 
     * @param  UpdateProductRequest     $request
     * @param  Seller                   $seller
     * @param  Product                  $product
     * @throws AppError
     * @return Product                  $product
     */
    public function execute(UpdateProductRequest $request, Seller $seller, Product $product): Product
    {
        if ($seller->id != $product->seller_id) {
            throw new AppError('The informed seller is not the product owner', 422);
        }

        $product->fill($request->only([
            'name',
            'description',
            'quantity'
        ]));

        if ($request->has('status')) {
            $product->status = $request->status;

            if ($product->isAvailable() && $product->categories()->count() == 0) {
                throw new AppError('An available product must have at least one category', 409);
            }
        }

        if ($product->isClean()) {
            throw new AppError('At least one value must be modified to update the product.', 409);
        }

        $product->save();

        return $product;
    }
}
