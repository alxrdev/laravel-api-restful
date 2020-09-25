<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\TransactionResource;
use App\Models\Product;
use App\Traits\ApiResponse;
use App\Traits\CollectionListHelpers;
use Illuminate\Http\Request;

class ProductTransactionController extends ApiController
{
    use ApiResponse, CollectionListHelpers;

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product, Request $request)
    {
        $transactions = $this->sortedFilteredAndPaginatedCollection($product->transactions, $request, ['quantity', 'created_at'], [], TransactionResource::class);
        return $this->paginatedResponse('All transactions', $transactions);
    }    
}
