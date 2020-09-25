<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\SellerResource;
use App\Models\Seller;
use App\Traits\CollectionListHelpers;
use Illuminate\Http\Request;

class SellerController extends ApiController
{
    use CollectionListHelpers;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sellers = $this->sortedFilteredAndPaginatedCollection(Seller::has('products')->get(), $request, ['created_at'], ['admin'], SellerResource::class);
        return $this->paginatedResponse('All sellers', $sellers);
    }

    /**
     * Display the specified resource.
     *
     * @param  Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function show(Seller $seller)
    {
        return $this->resourceResponse('All seller', new SellerResource($seller), 200);
    }
}
