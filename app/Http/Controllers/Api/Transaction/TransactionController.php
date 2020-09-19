<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Http\Controllers\Api\ApiController;
use App\Models\Transaction;

class TransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::all();
        return $this->collectionResponse('All transactions', $transactions);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        return $this->resourceResponse('Showing transaction', $transaction);
    }
}
