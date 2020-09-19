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

        if ($dto->name) {
            $user->name = $dto->name;
        }

        if ($dto->email && $user->email != $dto->email) {
            $tempUser = User::where('email', $dto->email)->first();

            if (!$tempUser) {
                $user->verified = User::UNVERIFIED_USER;
                $user->verification_token = User::verificationTokenGenerator();
                $user->email = $dto->email;
            } else {
                throw new AppError('An user with this email already exists', 409);
            }
        }

        if ($dto->password) {
            $user->password = bcrypt($dto->password);
        }

        if ($dto->admin) {
            if (!$user->isVerified()) {
                throw new AppError('User must be verified to change admin value.', 409);
            }

            $user->admin = $dto->admin;
        }

        if (!$user->isDirty()) {
            throw new AppError('At least one value must be modified to update the user.', 409);
        }

        $user->save();

        return $user;
    }
}
