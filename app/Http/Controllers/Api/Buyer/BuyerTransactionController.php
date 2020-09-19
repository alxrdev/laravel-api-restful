<?php

namespace App\Http\Controllers\Api\Buyer;

use App\Http\Controllers\Api\ApiController;
use App\Models\Buyer;

class BuyerTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        $transactions = $buyer->transactions;
        return $this->collectionResponse('All transactions', $transactions);
    }
}
