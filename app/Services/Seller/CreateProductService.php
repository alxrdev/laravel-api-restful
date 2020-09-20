<?php

namespace App\Services\Seller;

use App\Http\Requests\Seller\CreateProductRequest;
use App\Models\Product;
use App\Models\User;

class CreateProductService
{
    /**
     * Execute the service
     * 
     * @param  CreateProductRequest     $request
     * @param  User                     $seller
     * @throws AppError
     * @return Product                  $product
     */
    public function execute(CreateProductRequest $request, User $seller): Product
    {
        $data = $request->all();

        $data['status'] = Product::PRODUCT_UNAVAILABLE;
        $data['image'] = '1.jpg';
        $data['seller_id'] = $seller->id;

        $product = Product::create($data);

        return $product;
    }
}
