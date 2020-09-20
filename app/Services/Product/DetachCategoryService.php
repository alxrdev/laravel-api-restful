<?php

namespace App\Services\Product;

use App\Exceptions\AppError;
use App\Models\Category;
use App\Models\Product;

class DetachCategoryService
{
    /**
     * Execute the service
     * 
     * @param  Product  $product
     * @param  Category  $category
     * @throws AppError
     * @return array  $categories
     */
    public function execute(Product $product, Category $category)
    {
        $isNotAttached = !$product->categories()->find($category->id);

        if ($isNotAttached) {
            throw new AppError('Category is not attached to this product', 404);
        }

        $product->categories()->detach([$category->id]);

        $categories = $product->categories;

        return $categories;
    }
}
