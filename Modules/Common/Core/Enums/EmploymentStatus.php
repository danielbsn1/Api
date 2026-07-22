<?php

declare(strict_type=1);

namespace Modules\Common\Core\Enums;

enum EmploymentStatus: string
{
    case ACTIVE = 'Active';

    case INACTIVE = 'Inactive';

    case TERMINATED = 'Terminated';

    case ON_LEAVE = 'On_Leave';

    case SUSPENDED = 'Suspended';

    public static function all(): array
    {
        return [
            self::ACTIVE,
            self::INACTIVE,
            self::TERMINATED,
            self::ON_LEAVE,
            self::SUSPENDED,
        ];
    }

    public static function toArray(): array
    {
        return array_column(EmploymentStatus::cases(), 'value');
    }

    public function description(): string
    {
        return match ($this) {

            self::ACTIVE => 'Funcionario Ativo',
            self::INACTIVE => 'Funcionario Inativo',
            self::TERMINATED => 'Funcionario Encerrado',
            self::ON_LEAVE => 'Funcionario em Licença',
            self::SUSPENDED => 'Funcionario Suspenso',

        };
    }
}
