<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Illuminate\Support\Collection;
use Modules\Auth\Models\Permission;

final readonly class FetchPermissionsModules
{
    public function handle(): Collection
    {
        return Permission::query()
            ->select('module')
            ->distinct()
            ->get()
            ->map(fn ($item) => $item->module);
    }
}
