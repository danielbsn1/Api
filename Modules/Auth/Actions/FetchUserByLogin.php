<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Modules\Auth\Models\User;

final readonly class FetchUserByLogin
{
    public function handle(string $login): ?User
    {
        return User::getBy('login', $login);
    }
}
