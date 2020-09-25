<?php

namespace App\Http\Controllers\Api\Buyer;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\SellerResource;
use App\Models\Buyer;
use App\Traits\CollectionListHelpers;
use Illuminate\Http\Request;

class BuyerSellerController extends ApiController
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
        $sellersList = $buyer->transactions()
            ->with('product.seller')
            ->get()
            ->pluck('product.seller')
            ->unique('id')
            ->values();
        
        $sellers = $this->sortedFilteredAndPaginatedCollection($sellersList, $request, ['created_at'], ['admin'], SellerResource::class);
        
        return $this->paginatedResponse('All sellers', $sellers);
    }
}
