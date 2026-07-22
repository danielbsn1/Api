<?php

declare(strict_types=1);

namespace Modules\Common\Logs\Support;

enum AccessActions: string
{
    case LOGIN = 'LOGGED_IN';
    case LOGOUT = 'LOGGED_OUT';
    case DATATABLE_VIEW = 'VIEWED_DATATABLE';

    public static function all(): array
    {
        return [
            self::LOGIN,
            self::LOGOUT,
            self::DATATABLE_VIEW,
        ];
    }

    public static function toArray(): array
    {
        return array_column(AccessActions::cases(), 'value');
    }

    public function description(): string
    {
        return match ($this) {
            self::LOGIN => 'Login',
            self::LOGOUT => 'Logout',
            self::DATATABLE_VIEW => 'Tabela',
        };
    }

    public function message(): string
    {
        return match ($this) {
            self::LOGIN => 'Acessou o sistema.',
            self::LOGOUT => 'Saiu do sistema.',
            self::DATATABLE_VIEW => 'Visualizou a tabela de: ',
        };
    }
}
