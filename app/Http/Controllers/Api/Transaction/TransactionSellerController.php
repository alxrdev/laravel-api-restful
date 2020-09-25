<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\SellerResource;
use App\Models\Transaction;

class TransactionSellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function index(Transaction $transaction)
    {
        $seller = $transaction->product->seller;
        return $this->resourceResponse('Showing seller', new SellerResource($seller));
    }
}
