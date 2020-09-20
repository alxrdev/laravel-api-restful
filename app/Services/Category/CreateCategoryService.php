<?php

namespace App\Services\Category;

use App\Http\Requests\Category\CreateCategoryRequest;
use App\Models\Category;

class CreateCategoryService
{
    /**
     * Execute the service
     * 
     * @param  CreateCategoryRequest    $request
     * @throws AppError
     * @return Category                 $category
     */
    public function execute(CreateCategoryRequest $request) : Category
    {
        $fields = $request->all();

        $category = Category::create($fields);

        return $category;
    }
}
