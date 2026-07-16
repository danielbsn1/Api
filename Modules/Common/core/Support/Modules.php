<?php

declare(strict_types=1);

namespace Modules\Common\Core\Support;

enum Modules: string
{
    public static function all(): array
    {
        return [

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
