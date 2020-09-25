<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\TransactionResource;
use App\Models\Category;
use App\Traits\CollectionListHelpers;
use Illuminate\Http\Request;

class CategoryTransactionController extends ApiController
{
    use CollectionListHelpers;
    
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category, Request $request)
    {
        $transactionsList = $category->products()
            ->whereHas('transactions')
            ->with('transactions')
            ->get()
            ->pluck('transactions')
            ->collapse();
        
        $transactions = $this->sortedFilteredAndPaginatedCollection($transactionsList, $request, ['quantity', 'created_at'], [], TransactionResource::class);

        return $this->paginatedResponse('All transactions', $transactions);
    }
}
