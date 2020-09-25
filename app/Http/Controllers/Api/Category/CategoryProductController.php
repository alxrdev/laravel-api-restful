<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Traits\CollectionListHelpers;
use Illuminate\Http\Request;

class CategoryProductController extends ApiController
{
    use CollectionListHelpers;

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category, Request $request)
    {
        $products = $this->sortedFilteredAndPaginatedCollection($category->products, $request, ['quantity', 'created_at'], ['name', 'status'], ProductResource::class);
        return $this->paginatedResponse('All products', $products);
    }
}
