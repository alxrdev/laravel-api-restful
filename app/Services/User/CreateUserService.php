<?php

namespace App\Services\User;

use App\Dtos\IDto;
use App\Dtos\User\CreateUserDto;
use App\Models\User;
use App\Services\AbstractService;

class CreateUserService extends AbstractService
{
    /**
     * Execute the service
     * 
     * @param  CreateUserDto    $dto
     * @throws AppError
     * @return User             $user
     */
    public function execute(IDto $dto) : User
    {
        $this->isTheCorrectDto(CreateUserDto::class, $dto);

        $fields = $dto->getAllProperties();

        $fields['password'] = bcrypt($dto->password);
        $fields['verified'] = User::UNVERIFIED_USER;
        $fields['verification_token'] = User::verificationTokenGenerator();
        $fields['admin'] = User::REGULAR_USER;

        $user = User::create($fields);

        return $user;
    }
}
