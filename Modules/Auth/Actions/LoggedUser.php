<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Illuminate\Support\Facades\Auth;
use Modules\Auth\Models\User;

final readonly class LoggedUser
{
    public function handle(): User
    {
        $user = Auth::guard('api')->user();

        return $user;
    }
}
