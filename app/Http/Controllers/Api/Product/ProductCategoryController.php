<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Api\ApiController;
use App\Models\Product;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ProductCategoryController extends ApiController
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $categories = $product->categories;
        return $this->collectionResponse('All categories', $categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
