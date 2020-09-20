<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Product\CreateTransactionRequest;
use App\Models\Product;
use App\Models\User;
use App\Services\Product\CreateTransactionService;
use App\Traits\ApiResponse;

class ProductBuyerTransactionController extends ApiController
{
    use ApiResponse;

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateTransactionRequest  $request
     * @param  App\Models\Product $product
     * @param  App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTransactionRequest $request, Product $product, User $buyer)
    {
        $transaction = (new CreateTransactionService())->execute($request, $product, $buyer);
        return $this->resourceResponse('Transaction created', $transaction, 201);
    }
}
