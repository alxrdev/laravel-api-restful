<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Seller\CreateProductRequest;
use App\Models\Seller;
use App\Models\User;
use App\Services\Seller\CreateProductService;
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
     * @param  \App\Models\User                                $user
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seller $seller)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller)
    {
        //
    }
}
