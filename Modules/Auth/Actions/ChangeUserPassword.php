<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Illuminate\Support\Facades\Hash;
use Modules\Auth\DTOs\ChangeUserPasswordDTO;
use Modules\Auth\Models\User;
use Modules\Common\Core\Exceptions\NotFoundException;

final readonly class ChangeUserPassword
{
    public function handle(string $uuid, ChangeUserPasswordDTO $dto): void
    {
        $user = User::findByUuid($uuid);

        if (! $user) {
            throw new NotFoundException('User');
        }

        $user->update([
            'password' => Hash::make($dto->password),
        ]);
    }
}
