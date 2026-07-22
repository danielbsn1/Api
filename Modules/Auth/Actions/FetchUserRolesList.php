<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Illuminate\Database\Eloquent\Collection;

final readonly class FetchUserRolesList
{
    public function __construct(private FetchUser $fetchUser) {}

    public function handle(string $user): Collection
    {
        $user = $this->fetchUser->handle($user);

        return $user->roles;
    }
}
