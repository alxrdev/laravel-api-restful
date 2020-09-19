<?php

namespace App\Dtos\User;

use App\Dtos\AbstractDto;

class CreateUserDto extends AbstractDto
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
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ];
    }
}
