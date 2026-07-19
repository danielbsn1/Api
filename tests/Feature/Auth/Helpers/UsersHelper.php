<?php

declare(strict_types=1);

namespace Tests\Feature\Auth\Helpers;

use Modules\Auth\Models\Role;
use Modules\Auth\Models\User;

class UsersHelper
{
    public static function createTestUser(?Role $role = null): User
    {
        $user = User::factory()->make([
            'name' => fake()->name(),
            'login' => fake()->unique()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'active' => true,
        ]);

        $user->save();

        if ($role) {
            $user->assignRole($role);
        }

        return $user;
    }

    public static function dumbUserData(): array
    {
        return [
            'name' => 'John Doe',
            'login' => 'john-doe',
            'email' => 'john.doe@example.com',
            'email_verified_at' => now(),
            'password' => 's3CR3t@!',
            'active' => true,
        ];
    }
}
