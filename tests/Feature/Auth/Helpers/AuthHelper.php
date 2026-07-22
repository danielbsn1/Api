<?php

declare(strict_types=1);

namespace Tests\Feature\Auth\Helpers;

use Illuminate\Support\Facades\Password;
use Modules\Auth\Models\User;

class AuthHelper
{
    public static function createTestResetPasswordToken(User $user): string
    {
        $token = Password::createToken($user);

        return $token;
    }
}
