<?php

declare(strict_types=1);

namespace Modules\Common\Core\Support;

enum NotificationType: string
{
    case RELEASE_NOTES = 'release-notes';
    case EMPLOYEE_NOTES = 'employee-notes';
    case MANAGER_NOTES = 'manager-notes';
    case HRN_NOTES = 'hrn-notes';

    public static function all(): array
    {
        return [
            self::RELEASE_NOTES,
            self::EMPLOYEE_NOTES,
            self::MANAGER_NOTES,
            self::HRN-NOTES,

        ];
    }

    public static function toArray(): array
    {
        return array_column(NotificationType::cases(), 'value');
    }

    public function description(): string
    {
        return match ($this) {
            self::RELEASE_NOTES => 'Notificação de novas notas de versão',
            self::EMPLOYEE_NOTES => 'Notificaçao ao Funcionario',
            self::MANAGER_NOTES => 'Notificaçao do Gerente',
            self::HRN_NOTES => 'Notificaçao do RH',

        };
    }
}
