<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\CategoryResource;
use App\Models\Transaction;
use App\Traits\CollectionListHelpers;
use Illuminate\Http\Request;

class TransactionCategoryController extends ApiController
{
    use CollectionListHelpers;

    /**
     * Display a listing of the resource.
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function index(Transaction $transaction, Request $request)
    {
        $categories = $this->sortedFilteredAndPaginatedCollection($transaction->product->categories, $request, ['name', 'created_at'], [], CategoryResource::class);
        return $this->paginatedResponse('All categories', $categories);
    }
}
