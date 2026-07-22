<?php

declare(strict_types=1);

namespace Modules\Auth\Settings;

use Spatie\LaravelSettings\Settings;

class AuthSettings extends Settings
{
    public bool $redirect_on_first_login;

    public string $redirect_on_first_login_path;

    public bool $force_change_password_on_first_login;

    public static function group(): string
    {
        return 'auth';
    }
}
