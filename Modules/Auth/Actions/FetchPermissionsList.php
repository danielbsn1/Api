<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Auth\Models\Permission;

final readonly class FetchPermissionsList
{
    public function handle(): LengthAwarePaginator
    {
        return Permission::query()->paginate(20);
    }
}
