<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\TransactionResource;
use App\Models\Seller;
use App\Traits\CollectionListHelpers;
use Illuminate\Http\Request;

class SellerTransactionController extends ApiController
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
        $transactionsList = $seller->products()
            ->whereHas('transactions')
            ->with('transactions')
            ->get()
            ->pluck('transactions')
            ->collapse();

        $transactions = $this->sortedFilteredAndPaginatedCollection($transactionsList, $request, ['quantity', 'created_at'], [], TransactionResource::class);

        return $this->paginatedResponse('All transactions', $transactions);
    }
}
