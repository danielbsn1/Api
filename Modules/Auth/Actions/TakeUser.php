<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Illuminate\Support\Facades\Auth;
use Modules\Auth\Models\User;
use Modules\Auth\Support\ImpersonateManager;
use Modules\Common\Core\Exceptions\NotFoundException;

final readonly class TakeUser
{
    public function __construct(
        private ImpersonateManager $impersonateManager,
        private FetchUser $fetchUser,
    ) {}

    public function handle(string $uuid): string
    {
        $user = $this->fetchUser->handle($uuid);

        $impersonator = Auth::user();

        if (! $impersonator instanceof User) {
            throw new NotFoundException('Authenticated user');
        }

        return $this->impersonateManager->take($impersonator, $user);
    }
}
