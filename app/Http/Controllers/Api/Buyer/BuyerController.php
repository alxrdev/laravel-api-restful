<?php

namespace App\Http\Controllers\Api\Buyer;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\BuyerResource;
use App\Models\Buyer;
use App\Traits\CollectionListHelpers;
use Illuminate\Http\Request;

class BuyerController extends ApiController
{
    use CollectionListHelpers;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $buyers = $this->sortedFilteredAndPaginatedCollection(Buyer::has('transactions')->get(), $request, ['created_at'], ['admin'], BuyerResource::class);
        return $this->collectionResponse('All buyers', $buyers);
    }

    /**
     * Display the specified resource.
     *
     * @param  Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function show(Buyer $buyer)
    {
        return $this->resourceResponse('Showing buyer', new BuyerResource($buyer), 200);
    }
}
