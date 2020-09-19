<?php

namespace App\Services\Category;

use App\Dtos\Category\CreateCategoryDto;
use App\Dtos\IDto;
use App\Models\Category;
use App\Services\AbstractService;

class CreateCategoryService extends AbstractService
{
    /**
     * Execute the service
     * 
     * @param  CreateCategoryDto    $dto
     * @throws AppError
     * @return Category              $category
     */
    public function execute(IDto $dto) : Category
    {
        $this->isTheCorrectDto(CreateCategoryDto::class, $dto);

        $fields = $dto->getAllProperties();

        $category = Category::create($fields);

        return $category;
    }
}
