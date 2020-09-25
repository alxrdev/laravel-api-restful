<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\BuyerResource;
use App\Models\Category;
use App\Traits\CollectionListHelpers;
use Illuminate\Http\Request;

class CategoryBuyerController extends ApiController
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
        $buyersList = $category->products()
            ->whereHas('transactions')
            ->with('transactions.buyer')
            ->get()
            ->pluck('transactions')
            ->collapse()
            ->pluck('buyer')
            ->unique()
            ->values();

        $buyers = $this->sortedFilteredAndPaginatedCollection($buyersList, $request, ['created_at'], ['admin'], BuyerResource::class);
            
        return $this->paginatedResponse('All buyers', $buyers);
    }
}
