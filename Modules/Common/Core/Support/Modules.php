<?php

declare(strict_types=1);

namespace Modules\Common\Core\Support;

enum Modules: string
{
    case Auth = 'auth';

    public static function all(): array
    {
        return [
            Modules::Auth,
        ];
    }

    public static function toArray(): array
    {
        return array_column(Modules::cases(), 'value');
    }

    public function description(): string
    {
        return match ($this) {

        };
    }
}
