<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Modules\Auth\DTOs\UpdateUserAvatarDTO;
use Modules\Auth\Models\User;
use Modules\Common\Core\Exceptions\NotFoundException;

final readonly class UpdateUserAvatar
{
    public function handle(string $uuid, UpdateUserAvatarDTO $dto): User
    {
        /** @var User $user */
        $user = User::findOrFail($uuid);

        // Handle avatar upload
        $avatarPath = $dto->avatar->store('avatars', 'public');

        $user->avatar = $avatarPath;
        $user->save();

        return $user;
    }
}
