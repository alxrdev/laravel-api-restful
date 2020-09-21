<?php

namespace App\Services\User;

use App\Exceptions\AppError;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;

class UpdateUserService
{
    /**
     * @var UpdateUserRequest
     */
    private $request;

    /**
     * @var User
     */
    private $user;

    public function __construct(UpdateUserRequest $request, User $user)
    {
        $this->request = $request;
        $this->user = $user;
    }

    /**
     * Execute the service
     * 
     * @throws AppError
     * @return User                 $user
     */
    public function execute() : User
    {
        $this->handleNameChange();

        $this->handleEmailChange();

        $this->handlePasswordChange();

        $this->handleAdminChange();

        $this->userHasNotChanged();

        $this->user->save();

        return $this->user;
    }

    private function handleNameChange()
    {
        if ($this->request->name) {
            $this->user->name = $this->request->name;
        }
    }

    private function handleEmailChange()
    {
        if (!$this->request->email || $this->user->email == $this->request->email) {
            return false;
        }

        $tempUser = User::where('email', $this->request->email)->first();

        if ($tempUser) {
            throw new AppError('An user with this email already exists', 409);
        }

        $this->user->verified = User::UNVERIFIED_USER;
        $this->user->verification_token = User::verificationTokenGenerator();
        $this->user->email = $this->request->email;
    }

    private function handlePasswordChange()
    {
        if ($this->request->password) {
            $this->user->password = bcrypt($this->request->password);
        }
    }

    private function handleAdminChange()
    {
        if (!$this->request->admin) {
            return false;
        }

        if (!$this->user->isVerified()) {
            throw new AppError('User must be verified to change admin value.', 409);
        }

        $this->user->admin = $this->request->admin;
    }

    private function userHasNotChanged()
    {
        if (!$this->user->isDirty()) {
            throw new AppError('At least one value must be modified to update the user.', 409);
        }
    }
}
