<?php

namespace App\Services\User;

use App\Dtos\IDto;
use App\Dtos\User\UpdateUserDto;
use App\Exceptions\AppError;
use App\Models\User;
use App\Services\AbstractService;

class UpdateUserService extends AbstractService
{
    /**
     * Execute the service
     * 
     * @param  UpdateUserDto    $dto
     * @throws AppError
     * @return User             $user
     */
    public function execute(IDto $dto) : User
    {
        $this->isTheCorrectDto(UpdateUserDto::class, $dto);
        
        $user = User::findOrFail($dto->id);

        $user = $this->handleChanges($dto, $user);

        if (!$user->isDirty()) {
            throw new AppError('At least one value must be modified to update the user.', 409);
        }

        $user->save();

        return $user;
    }

    private function handleChanges(UpdateUserDto $dto, User $user) : User
    {
        $user = $this->theNameHasChanged($dto, $user);

        $user = $this->theEmailHasChanged($dto, $user);

        $user = $this->thePasswordHasChanged($dto, $user);

        $user = $this->theAdminHasChanged($dto, $user);

        return $user;
    }

    private function theNameHasChanged(UpdateUserDto $dto, User $user) : User
    {
        if ($dto->name) {
            $user->name = $dto->name;
        }

        return $user;
    }

    private function theEmailHasChanged(UpdateUserDto $dto, User $user) : User
    {
        if (!$dto->email || $user->email == $dto->email) {
            return $user;
        }

        $tempUser = User::where('email', $dto->email)->first();

        if ($tempUser) {
            throw new AppError('An user with this email already exists', 409);
        }

        $user->verified = User::UNVERIFIED_USER;
        $user->verification_token = User::verificationTokenGenerator();
        $user->email = $dto->email;

        return $user;
    }

    private function thePasswordHasChanged(UpdateUserDto $dto, User $user) : User
    {
        if ($dto->password) {
            $user->password = bcrypt($dto->password);
        }

        return $user;
    }

    private function theAdminHasChanged(UpdateUserDto $dto, User $user) : User
    {
        if (!$dto->admin) {
            return $user;
        }

        if (!$user->isVerified()) {
            throw new AppError('User must be verified to change admin value.', 409);
        }

        $user->admin = $dto->admin;

        return $user;
    }
}
