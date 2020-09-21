<?php

namespace App\Services\User;

use App\Exceptions\AppError;
use App\Mail\User\UserCreated;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ResendUserVerificationEmailService
{
    /**
     * @var User
     */
    private $user;

    /**
     * Create a new instance
     * 
     * @param  User  $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the service
     * 
     * @throws AppError
     */
    public function execute()
    {
        $this->userAlreadyVerified();

        $user = $this->user;

        retry(5, function() use ($user) {
            Mail::to($user->email)->send(new UserCreated($user));
        }, 100);
    }

    private function userAlreadyVerified()
    {
        if ($this->user->isVerified()) {
            throw new AppError('User already verified', 409);
        }
    }
}
