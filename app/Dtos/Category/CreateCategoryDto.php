<?php

namespace App\Dtos\Category;

use App\Dtos\AbstractDto;

class CreateCategoryDto extends AbstractDto
{
    /**
     * Define all validation rules
     * 
     * @return array Validation rules
     */
    protected function configureValidationRules() : array
    {
        return [
            'name' => 'required',
            'description' => 'required'
        ];
    }
}
