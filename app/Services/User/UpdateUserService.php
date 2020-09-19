<?php

namespace App\Services\User;

use App\Exceptions\AppError;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;

class UpdateUserService
{
    public function execute(UpdateUserRequest $request, int $id) : User
    {
        $user = User::findOrFail($id);        

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email') && $user->email != $request->email) {
            $tempUser = User::where('email', $request->email)->first();

            if (!$tempUser) {
                $user->verified = User::UNVERIFIED_USER;
                $user->verification_token = User::verificationTokenGenerator();
                $user->email = $request->email;
            } else {
                throw new AppError('An user with this email already exists', 409);
            }
        }

        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->has('admin')) {
            if (!$user->isVerified()) {
                throw new AppError('User must be verified to change admin value.', 409);
            }

            $user->admin = $request->admin;
        }

        if (!$user->isDirty()) {
            throw new AppError('At least one value must be modified to update the user.', 409);
        }

        $user->save();

        return $user;
    }
}
