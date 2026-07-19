<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Modules\Common\Core\Enums\Permissions;

return new class extends Migration
{
    public function up(): void
    {
        $now = now()->toDateTimeString();

        foreach (Permissions::cases() as $permission) {
            DB::table('permissions')->insertOrIgnore([
                'name' => $permission->value,
                'guard_name' => 'api',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        DB::table('roles')->insertOrIgnore([
            'name' => 'admin',
            'guard_name' => 'api',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('roles')->insertOrIgnore([
            'name' => 'test-role',
            'guard_name' => 'api',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $adminRoleId = DB::table('roles')->where('name', 'admin')->where('guard_name', 'api')->first()?->id;

        if ($adminRoleId) {
            $adminPermissions = [
                Permissions::USER_VIEW->value,
                Permissions::USER_CREATE->value,
                Permissions::ROLE_UPDATE->value,
            ];

            foreach ($adminPermissions as $permName) {
                $permission = DB::table('permissions')->where('name', $permName)->where('guard_name', 'api')->first();
                if ($permission) {
                    DB::table('role_has_permissions')->insertOrIgnore([
                        'role_id' => $adminRoleId,
                        'permission_id' => $permission->id,
                    ]);
                }
            }
        }
    }

    public function down(): void
    {
        DB::table('role_has_permissions')->delete();
        DB::table('permissions')->where('guard_name', 'api')->delete();
        DB::table('roles')->where('guard_name', 'api')->delete();
    }
};
