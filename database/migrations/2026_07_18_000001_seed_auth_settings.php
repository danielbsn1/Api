<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now()->toDateTimeString();

        DB::table('settings')->insert([
            [
                'group' => 'auth',
                'name' => 'redirect_on_first_login',
                'locked' => false,
                'payload' => json_encode(true),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'group' => 'auth',
                'name' => 'redirect_on_first_login_path',
                'locked' => false,
                'payload' => json_encode('/dashboard'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'group' => 'auth',
                'name' => 'force_change_password_on_first_login',
                'locked' => false,
                'payload' => json_encode(true),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    public function down(): void
    {
        DB::table('settings')->where('group', 'auth')->delete();
    }
};
