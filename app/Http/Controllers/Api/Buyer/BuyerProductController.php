<?php

namespace App\Http\Controllers\Api\Buyer;

use App\Http\Controllers\Api\ApiController;
use App\Models\Buyer;

class BuyerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        $products = $buyer->transactions()
            ->with('product')
            ->get()
            ->pluck('product');

        return $this->collectionResponse('All products', $products);
    }
}
