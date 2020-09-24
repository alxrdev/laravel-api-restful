<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Traits\CollectionListHelpers;
use Illuminate\Http\Request;

class TransactionController extends ApiController
{
    use CollectionListHelpers;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $transactions = $this->sortedFilteredAndPaginatedCollection(Transaction::all(), $request, ['quantity', 'created_at'], [], TransactionResource::class);
        return $this->paginatedResponse('All transactions', $transactions);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        return $this->resourceResponse('Showing transaction', new TransactionResource($transaction));
    }
}
