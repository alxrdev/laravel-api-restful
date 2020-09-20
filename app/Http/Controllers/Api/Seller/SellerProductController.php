<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Seller\CreateProductRequest;
use App\Http\Requests\Seller\UpdateProductRequest;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use App\Services\Seller\CreateProductService;
use App\Services\Seller\DeleteProductService;
use App\Services\Seller\UpdateProductService;
use Illuminate\Http\Request;

class SellerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $products = $seller->products;
        return $this->collectionResponse('All products', $products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Seller\CreateProductRequest  $request
     * @param  \App\Models\User                                $seller
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request, User $seller)
    {
        $product = (new CreateProductService())->execute($request, $seller);
        return $this->resourceResponse('Product created', $product, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Seller\UpdateProductRequest  $request
     * @param  \App\Models\Seller  $seller
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Seller $seller, Product $product)
    {
        $product = (new UpdateProductService())->execute($request, $seller, $product);
        return $this->resourceResponse('Product updated', $product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Seller  $seller
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller, Product $product)
    {
        (new DeleteProductService())->execute($seller, $product);
        return $this->successResponse('Product deleted', 204);
    }
}
