<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\SellerResource;
use App\Models\Category;
use App\Traits\CollectionListHelpers;
use Illuminate\Http\Request;

class CategorySellerController extends ApiController
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
        $sellersList = $category->products()
            ->with('seller')
            ->get()
            ->pluck('seller')
            ->unique()
            ->values();

        $sellers = $this->sortedFilteredAndPaginatedCollection($sellersList, $request, ['created_at'], ['admin'], SellerResource::class);

        return $this->paginatedResponse('All sellers', $sellers);
    }
}
