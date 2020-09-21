<?php

namespace App\Services\User;

use App\Models\User;

class VerifyUserService
{
    /**
     * Execute the service
     * 
     * @param  string  $token
     * @throws AppError
     * @return User
     */
    public function execute(string $token)
    {
        $user = User::where('verification_token', $token)->firstOrFail();
        
        $user->verified = User::VERIFIED_USER;
        $user->verification_token = null;
        $user->email_verified_at = time();

        $user->save();
    }
}
