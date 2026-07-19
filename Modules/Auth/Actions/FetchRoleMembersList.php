<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Auth\Models\User;

final readonly class FetchRoleMembersList
{
    public function handle(int $id): LengthAwarePaginator
    {
        return User::whereHas('roles', fn ($query) => $query->where('roles.id', $id))->paginate(20);
    }
}
