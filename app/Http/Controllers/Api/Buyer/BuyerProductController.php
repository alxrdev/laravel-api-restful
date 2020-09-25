<?php

namespace App\Http\Controllers\Api\Buyer;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\ProductResource;
use App\Models\Buyer;
use App\Traits\CollectionListHelpers;
use Illuminate\Http\Request;

class BuyerProductController extends ApiController
{
    use CollectionListHelpers;
    
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer, Request $request)
    {
        $productsList = $buyer->transactions()
            ->with('product')
            ->get()
            ->pluck('product');
        
        $products = $this->sortedFilteredAndPaginatedCollection($productsList, $request, ['quantity', 'created_at'], ['name', 'status'], ProductResource::class);

        return $this->paginatedResponse('All products', $products);
    }
}
