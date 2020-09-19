<?php

namespace App\Dtos\User;

use App\Dtos\AbstractDto;
use App\Models\User;

class UpdateUserDto extends AbstractDto
{
    /**
     * Define all validation rules
     * 
     * @return array Validation rules
     */
    protected function configureValidationRules() : array
    {
        return [
            'id' => 'required|numeric',
            'email' => 'email',
            'password' => 'min:6|confirmed',
            'admin' => 'in:' . User::ADMIN_USER . ',' . User::REGULAR_USER
        ];
    }
}
