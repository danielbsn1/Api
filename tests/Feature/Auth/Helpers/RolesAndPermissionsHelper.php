<?php

declare(strict_types=1);

namespace Tests\Feature\Auth\Helpers;

use Modules\Auth\Models\Permission;
use Modules\Auth\Models\Role;

class RolesAndPermissionsHelper
{
    public static function createTestRole(): Role
    {
        $role = new Role([
            'name' => fake()->unique()->word(),
            'description' => fake()->sentence(),
        ]);

        $role->save();

        return $role;
    }

    public static function dumbRoleData(): array
    {
        return [
            'name' => 'foo-role',
            'description' => 'foo-description',
        ];
    }

    public static function createTestPermission(): Permission
    {
        $permission = new Permission([
            'name' => fake()->unique()->word(),
            'description' => fake()->sentence(),
        ]);

        $permission->save();

        return $permission;
    }

    public static function dumbPermissionData(): array
    {
        return [
            'name' => 'user.view',
            'description' => 'View users',
        ];
    }
}