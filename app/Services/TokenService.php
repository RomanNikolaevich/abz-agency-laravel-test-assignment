<?php

namespace App\Services;

use App\Models\User;

class TokenService
{
    public function createToken(User $user): string
    {
        $user->tokens()->delete();

        $token = $user->createToken('api');

        return $token->plainTextToken;
    }
}
