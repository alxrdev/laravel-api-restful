<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Api\ApiController;
use App\Models\Seller;

class SellerCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $categories = $seller->products()
            ->with('categories')
            ->get()
            ->pluck('categories')
            ->collapse()
            ->unique()
            ->values();
        
        return $this->collectionResponse('All categories', $categories);
    }
}
