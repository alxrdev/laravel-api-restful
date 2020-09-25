<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\BuyerResource;
use App\Models\Seller;
use App\Traits\CollectionListHelpers;
use Illuminate\Http\Request;

class SellerBuyerController extends ApiController
{
    use CollectionListHelpers;

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller, Request $request)
    {
        $buyersList = $seller->products()
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
