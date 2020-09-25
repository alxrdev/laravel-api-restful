<?php

namespace App\Http\Controllers\Api\Buyer;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\TransactionResource;
use App\Models\Buyer;
use App\Traits\CollectionListHelpers;
use Illuminate\Http\Request;

class BuyerTransactionController extends ApiController
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
        $transactions = $this->sortedFilteredAndPaginatedCollection($buyer->transactions, $request, ['quantity', 'created_at'], [], TransactionResource::class);
        return $this->paginatedResponse('All transactions', $transactions);
    }
}
