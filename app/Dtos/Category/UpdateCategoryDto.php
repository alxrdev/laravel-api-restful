<?php

namespace App\Dtos\Category;

use App\Dtos\AbstractDto;

class UpdateCategoryDto extends AbstractDto
{
    /**
     * Define all validation rules
     * 
     * @return array Validation rules
     */
    protected function configureValidationRules() : array
    {
        return [
            'category' => 'required',
            'name' => 'string',
            'description' => 'string'
        ];
    }
}
