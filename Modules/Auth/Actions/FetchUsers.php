<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Auth\Models\User;

final readonly class FetchUsers
{
    public function handle(?string $search = null, ?int $perPage = null): LengthAwarePaginator
    {
        $query = User::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('login', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        return $query->paginate($perPage ?? 20);
    }
}
