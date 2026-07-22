<?php

declare(strict_types=1);

namespace Modules\Common\Core\Support\Documents;

final readonly class Cep
{
    private const LENGTH = 8;

    public static function format(string $cep): string
    {
        $cep = self::unformat($cep);

        if (strlen($cep) !== self::LENGTH) {
            return $cep;
        }

        return substr($cep, 0, 5).'-'.substr($cep, 5, 3);
    }

    public static function unformat(string $cep): string
    {
        return preg_replace('/\D/', '', $cep);
    }

    public static function validate(string $cep): bool
    {
        $cep = self::unformat($cep);

        return strlen($cep) === self::LENGTH;
    }

    public static function isFormatted(string $cep): bool
    {
        return (bool) preg_match('/^\d{5}-\d{3}$/', $cep);
    }

    public static function isUnformatted(string $cep): bool
    {
        return (bool) preg_match('/^\d{8}$/', $cep);
    }

    public static function normalize(string $cep): string
    {
        return self::unformat($cep);
    }
}
