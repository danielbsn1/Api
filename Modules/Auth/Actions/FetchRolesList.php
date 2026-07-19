<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Auth\Models\Role;

final readonly class FetchRolesList
{
    public function handle(?string $search = null, ?int $perPage = null): LengthAwarePaginator
    {
        $query = Role::query();

        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        return $query->paginate($perPage ?? 20);
    }
}
