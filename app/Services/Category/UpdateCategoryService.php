<?php

namespace App\Services\Category;

use App\Dtos\Category\UpdateCategoryDto;
use App\Dtos\IDto;
use App\Exceptions\AppError;
use App\Models\Category;
use App\Services\AbstractService;

class UpdateCategoryService extends AbstractService
{
    /**
     * Execute the service
     * 
     * @param  UpdateCategoryDto    $dto
     * @throws AppError
     * @return Category              $category
     */
    public function execute(IDto $dto) : Category
    {
        $this->isTheCorrectDto(UpdateCategoryDto::class, $dto);

        $category = $dto->category;

        $category->fill($dto->getAllProperties());

        if ($category->isClean()) {
            throw new AppError('At least one value must be modified to update the category.', 409);
        }

        $category->save();

        return $category;
    }
}
