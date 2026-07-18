<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Modules\Auth\Models\User;
use Modules\Common\Core\Exceptions\NotFoundException;

final readonly class FetchUser
{
    public function handle(string $uuid): User
    {
        $user = User::find($uuid);

        if (!$user) {
            throw new NotFoundException('User');
        }

        return $user;
    }
}
