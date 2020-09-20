<?php

namespace App\Services\User;

use App\Http\Requests\User\CreateUserRequest;
use App\Models\User;

class CreateUserService
{
    /**
     * Execute the service
     * 
     * @param  CreateUserRequest    $request
     * @throws AppError
     * @return User                 $user
     */
    public function execute(CreateUserRequest $request) : User
    {
        $fields = $request->all();

        $fields['password'] = bcrypt($request->password);
        $fields['verified'] = User::UNVERIFIED_USER;
        $fields['verification_token'] = User::verificationTokenGenerator();
        $fields['admin'] = User::REGULAR_USER;

        $user = User::create($fields);

        return $user;
    }
}
