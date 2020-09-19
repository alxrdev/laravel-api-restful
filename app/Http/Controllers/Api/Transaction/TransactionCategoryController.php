<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Http\Controllers\Api\ApiController;
use App\Models\Transaction;

class TransactionCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function index(Transaction $transaction)
    {
        $categories = $transaction->product->categories;
        return $this->collectionResponse('All categories', $categories);
    }
}
