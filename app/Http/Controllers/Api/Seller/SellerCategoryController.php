<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\CategoryResource;
use App\Models\Seller;
use App\Traits\CollectionListHelpers;
use Illuminate\Http\Request;

class SellerCategoryController extends ApiController
{
    use CollectionListHelpers;

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller, Request $request)
    {
        $categoriesList = $seller->products()
            ->with('categories')
            ->get()
            ->pluck('categories')
            ->collapse()
            ->unique()
            ->values();

        $categories = $this->sortedFilteredAndPaginatedCollection($categoriesList, $request, ['name', 'created_at'], [], CategoryResource::class);
        
        return $this->paginatedResponse('All categories', $categories);
    }
}
