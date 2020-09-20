<?php

namespace App\Services\User;

use App\Exceptions\AppError;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;

class UpdateUserService
{
    /**
     * Execute the service
     * 
     * @param  UpdateUserRequest    $request
     * @throws AppError
     * @return User                 $user
     */
    public function execute(UpdateUserRequest $request, User $user) : User
    {
        $user = $this->handleChanges($request, $user);

        if (!$user->isDirty()) {
            throw new AppError('At least one value must be modified to update the user.', 409);
        }

        $user->save();

        return $user;
    }

    private function handleChanges(UpdateUserRequest $request, User $user) : User
    {
        $user = $this->theNameHasChanged($request, $user);

        $user = $this->theEmailHasChanged($request, $user);

        $user = $this->thePasswordHasChanged($request, $user);

        $user = $this->theAdminHasChanged($request, $user);

        return $user;
    }

    private function theNameHasChanged(UpdateUserRequest $request, User $user) : User
    {
        if ($request->name) {
            $user->name = $request->name;
        }

        return $user;
    }

    private function theEmailHasChanged(UpdateUserRequest $request, User $user) : User
    {
        if (!$request->email || $user->email == $request->email) {
            return $user;
        }

        $tempUser = User::where('email', $request->email)->first();

        if ($tempUser) {
            throw new AppError('An user with this email already exists', 409);
        }

        $user->verified = User::UNVERIFIED_USER;
        $user->verification_token = User::verificationTokenGenerator();
        $user->email = $request->email;

        return $user;
    }

    private function thePasswordHasChanged(UpdateUserRequest $request, User $user) : User
    {
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        return $user;
    }

    private function theAdminHasChanged(UpdateUserRequest $request, User $user) : User
    {
        if (!$request->admin) {
            return $user;
        }

        if (!$user->isVerified()) {
            throw new AppError('User must be verified to change admin value.', 409);
        }

        $user->admin = $request->admin;

        return $user;
    }
}
