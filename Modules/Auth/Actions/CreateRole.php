<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Modules\Auth\DTOs\CreateRoleDTO;
use Modules\Auth\Models\Role;

final readonly class CreateRole
{
    public function handle(CreateRoleDTO $dto): Role
    {
        /** @var Role $role */
        $role = $dto->toModel(Role::class);

        return $role;
    }
}
