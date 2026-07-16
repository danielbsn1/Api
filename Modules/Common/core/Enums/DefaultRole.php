<?php

declare(strict_types=1);

namespace Modules\Common\Core\Enums;

enum DefaultRole: string
{
    case SUPER_ADMIN = 'super-admin';
    case ADMIN = 'admin';

    case MANAGER = 'manager';
    case SUPERVISOR = 'supervisor';

    case EMPLOYEE = 'employee';

    case CUSTOMER = 'customer';

    case GUEST = 'guest';

    public static function all(): array
    {
        return self::cases();
    }

    public static function hidden(): array
    {
        return [
            self::SUPER_ADMIN,
        ];
    }

    public static function protected(): array
    {
        return [
            self::SUPER_ADMIN,
            self::ADMIN,
        ];
    }

    public function label(): string
    {
        return match ($this) {

            self::SUPER_ADMIN => 'Super Administrator',

            self::ADMIN => 'Administrator',

            self::MANAGER => 'Manager',

            self::SUPERVISOR => 'Supervisor',

            self::EMPLOYEE => 'Employee',

            self::CUSTOMER => 'Customer',

            self::GUEST => 'Guest',
        };
    }

    public function description(): string
    {
        return match ($this) {

            self::SUPER_ADMIN => 'Full access to the entire platform.',

            self::ADMIN => 'Administrative access with permission management.',

            self::MANAGER => 'Responsible for managing departments and teams.',

            self::SUPERVISOR => 'Supervises employees and operational processes.',

            self::EMPLOYEE => 'Standard internal user.',

            self::CUSTOMER => 'External customer with limited access.',

            self::GUEST => 'Read-only access.',
        };
    }

    public function level(): int
    {
        return match ($this) {

            self::SUPER_ADMIN => 100,

            self::ADMIN => 90,

            self::MANAGER => 70,

            self::SUPERVISOR => 60,

            self::EMPLOYEE => 40,

            self::CUSTOMER => 20,

            self::GUEST => 10,
        };
    }

    public function color(): string
    {
        return match ($this) {

            self::SUPER_ADMIN => 'danger',

            self::ADMIN => 'primary',

            self::MANAGER => 'success',

            self::SUPERVISOR => 'warning',

            self::EMPLOYEE => 'info',

            self::CUSTOMER => 'secondary',

            self::GUEST => 'gray',
        };
    }

    public function icon(): string
    {
        return match ($this) {

            self::SUPER_ADMIN => 'shield-check',

            self::ADMIN => 'user-circle',

            self::MANAGER => 'briefcase',

            self::SUPERVISOR => 'users',

            self::EMPLOYEE => 'identification',

            self::CUSTOMER => 'user',

            self::GUEST => 'eye',
        };
    }

    public function permissions(): array
    {
        return match ($this) {

            self::SUPER_ADMIN => Permissions::cases(),

            self::ADMIN => [
                Permissions::USER_VIEW,
                Permissions::USER_CREATE,
                Permissions::ROLE_UPDATE,
            ],

            self::MANAGER => [
                // ...
            ],

            self::SUPERVISOR => [
                // ...
            ],

            self::EMPLOYEE => [
                // ...
            ],

            self::CUSTOMER => [
                // ...
            ],

            self::GUEST => [],
        };
    }

    public function isProtected(): bool
    {
        return in_array($this, self::protected(), true);
    }

    public function isHidden(): bool
    {
        return in_array($this, self::hidden(), true);
    }
}
