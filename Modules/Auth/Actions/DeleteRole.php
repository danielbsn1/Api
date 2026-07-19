<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Modules\Auth\Models\Role;
use Modules\Common\Core\Exceptions\NotFoundException;

final readonly class DeleteRole
{
    public function handle(int $id): void
    {
        $role = Role::find($id);

        if (! $role) {
            throw new NotFoundException('Role');
        }

        $role->delete();
    }
}
