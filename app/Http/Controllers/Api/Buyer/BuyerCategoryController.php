<?php

namespace App\Http\Controllers\Api\Buyer;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\CategoryResource;
use App\Models\Buyer;
use App\Traits\CollectionListHelpers;
use Illuminate\Http\Request;

class BuyerCategoryController extends ApiController
{
    use CollectionListHelpers;
    
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer, Request $request)
    {
        $categoriesList = $buyer->transactions()
            ->with('product.categories')
            ->get()
            ->pluck('product.categories')
            ->collapse()
            ->unique('id')
            ->values();
        
        $categories = $this->sortedFilteredAndPaginatedCollection($categoriesList, $request, ['name', 'created_at'], [], CategoryResource::class);
        
        return $this->paginatedResponse('All categories', $categories);
    }
}
