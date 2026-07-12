<?php

declare(strict_types=1);

namespace Modules\Common\Core\Enums;

enum Role: string
{
    case ADMIN       = 'admin';
    case RH_MANAGER  = 'rh_manager';
    case RH_ANALYST  = 'rh_analyst';
    case MANAGER     = 'manager';
    case EMPLOYEE    = 'employee';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN      => 'Administrador',
            self::RH_MANAGER => 'Gestor de RH',
            self::RH_ANALYST => 'Analista de RH',
            self::MANAGER    => 'Gestor de Departamento',
            self::EMPLOYEE   => 'Funcionário',
        };
    }

    public function canManage(): bool
    {
        return match ($this) {
            self::ADMIN, self::RH_MANAGER => true,
            default                       => false,
        };
    }

    public function canEdit(): bool
    {
        return match ($this) {
            self::ADMIN, self::RH_MANAGER, self::RH_ANALYST => true,
            default                                          => false,
        };
    }

    public function canView(): bool
    {
        return true;
    }

    public function canDelete(): bool
    {
        return $this === self::ADMIN;
    }

    public static function all(): array
    {
        return array_column(self::cases(), 'value');
    }
}
