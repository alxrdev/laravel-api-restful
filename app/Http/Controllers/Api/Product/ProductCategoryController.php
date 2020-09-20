<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Api\ApiController;
use App\Models\Category;
use App\Models\Product;
use App\Services\Product\DetachCategoryService;
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
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product, Category $category)
    {
        $product->categories()->syncWithoutDetaching([$category->id]);
        $categories = $product->categories;

        return $this->collectionResponse('Category attached', $categories);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Category $category)
    {
        $categories = (new DetachCategoryService())->execute($product, $category);
        return $this->collectionResponse('Category detached', $categories);
    }
}
