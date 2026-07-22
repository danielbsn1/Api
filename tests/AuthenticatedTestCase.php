<?php

namespace Tests;

use Modules\Auth\Models\Permission;
use Modules\Auth\Models\Role;
use Modules\Auth\Models\User;
use PragmaRX\Google2FA\Google2FA;

abstract class AuthenticatedTestCase extends TestCase
{
    protected function loginAndGetToken(?array $params = null, ?User $user = null): string
    {
        if (is_null($params) && is_null($user)) {
            $user = User::factory()->create([
                'password' => bcrypt('password'),
            ]);
            $params = [
                'login' => $user->login,
                'password' => 'password',
            ];
        } elseif (is_null($params) && $user) {
            $params = [
                'login' => $user->login,
                'password' => 'password',
            ];
        }

        $response = $this->postJson(
            'api/v1/auth/login',
            $params,
            [
                'X-Domain' => 'foo',
                'Accept' => 'application/json',
            ]
        );

        $response->assertStatus(200);

        return $response->json('token');
    }

    protected function loginWith2faAndGetToken(User $user): string
    {
        $google2fa = app(Google2FA::class);
        $secret = decrypt($user->two_factor_secret);
        $code = $google2fa->getCurrentOtp($secret);

        $response = $this->postJson(
            'api/v1/auth/login/2fa',
            [
                'uuid' => $user->uuid,
                'code' => $code,
            ],
            [
                'X-Domain' => 'foo',
                'Accept' => 'application/json',
            ]
        );

        $response->assertStatus(200);

        return $response->json('token');
    }

    protected function loginAndGetTokenWithPermissions(array $permissions, ?User $user = null): string
    {
        $role = Role::firstOrCreate(['name' => 'admin']);

        foreach ($permissions as $permissionName) {
            $permission = Permission::firstOrCreate(['name' => $permissionName]);
            $role->givePermissionTo($permission);
        }

        $user = $user ?? User::factory()->create([
            'password' => bcrypt('password'),
        ]);
        $user->assignRole($role);

        $params = [
            'login' => $user->login,
            'password' => 'password',
        ];

        return $this->loginAndGetToken($params);
    }

    protected function authenticateWithPermissions(array $permissions, ?User $user = null): string
    {
        return $this->loginAndGetTokenWithPermissions($permissions, $user);
    }

    protected function loginAndGetTokenWithRole(User $user): string
    {
        $params = [
            'login' => $user->login,
            'password' => 'password',
        ];

        return $this->loginAndGetToken($params);
    }
}
