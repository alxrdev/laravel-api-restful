<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Product;
use App\Services\Product\DetachCategoryService;
use App\Traits\ApiResponse;
use App\Traits\CollectionListHelpers;
use Illuminate\Http\Request;

class ProductCategoryController extends ApiController
{
    use ApiResponse, CollectionListHelpers;

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product, Request $request)
    {
        $categories = $this->sortedFilteredAndPaginatedCollection($product->categories, $request, ['name', 'created_at'], [], CategoryResource::class);
        return $this->paginatedResponse('All categories', $categories);
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
        return $this->collectionResponse('Category attached', CategoryResource::collection($product->categories));
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
        (new DetachCategoryService())->execute($product, $category);
        return response()
            ->noContent();
    }
}
