<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\BuyerResource;
use App\Models\Product;
use App\Traits\ApiResponse;
use App\Traits\CollectionListHelpers;
use Illuminate\Http\Request;

class ProductBuyerController extends ApiController
{
    use ApiResponse, CollectionListHelpers;

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product, Request $request)
    {
        $buyersList = $product->transactions()
            ->with('buyer')
            ->get()
            ->pluck('buyer')
            ->unique()
            ->values();

        $buyers = $this->sortedFilteredAndPaginatedCollection($buyersList, $request, ['created_at'], ['admin'], BuyerResource::class);
        
        return $this->paginatedResponse('All buyers', $buyers);
    }   
}
