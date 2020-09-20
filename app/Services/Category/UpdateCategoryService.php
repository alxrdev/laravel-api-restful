<?php

namespace App\Services\Category;

use App\Exceptions\AppError;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;

class UpdateCategoryService
{
    /**
     * Execute the service
     * 
     * @param  UpdateCategoryRequest    $request
     * @param  Category                 $category
     * @throws AppError
     * @return Category                 $category
     */
    public function execute(UpdateCategoryRequest $request, Category $category) : Category
    {
        $category->fill($request->all());

        if ($category->isClean()) {
            throw new AppError('At least one value must be modified to update the category.', 409);
        }

        $category->save();

        return $category;
    }
}
