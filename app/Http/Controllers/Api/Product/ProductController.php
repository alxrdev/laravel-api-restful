<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Traits\CollectionListHelpers;
use Illuminate\Http\Request;

class ProductController extends ApiController
{
    use CollectionListHelpers;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = $this->sortedFilteredAndPaginatedCollection(Product::all(), $request, ['quantity', 'created_at'], ['name', 'status'], ProductResource::class);
        return $this->paginatedResponse('All products', $products);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return $this->resourceResponse('Showing product', new ProductResource($product));
    }
}
