<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Api\ApiController;
use App\Models\Seller;

class SellerTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $transactions = $seller->products()
            ->whereHas('transactions')
            ->with('transactions')
            ->get()
            ->pluck('transactions')
            ->collapse();

        return $this->collectionResponse('All transactions', $transactions);
    }
}
