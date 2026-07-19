<?php

declare(strict_types=1);

namespace Modules\Common\Core\Support\Documents;

final readonly class Cpf
{
    private const LENGTH = 11;

    public static function format(string $cpf): string
    {
        $cpf = self::unformat($cpf);

        return substr($cpf, 0, 3).'.'.substr($cpf, 3, 3).'.'.substr($cpf, 6, 3).'-'.substr($cpf, 9, 2);
    }

    public static function unformat(string $cpf): string
    {
        return preg_replace('/\D/', '', $cpf);
    }

    public static function validate(string $cpf): bool
    {
        $cpf = self::unformat($cpf);

        if (strlen($cpf) !== self::LENGTH || preg_match('/^(\d)\1+$/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            $sum = 0;
            for ($i = 0; $i < $t; $i++) {
                $sum += (int) $cpf[$i] * ($t + 1 - $i);
            }
            $remainder = (($sum * 10) % 11) % 10;
            if ((int) $cpf[$t] !== $remainder) {
                return false;
            }
        }

        return true;
    }

    public static function isFormatted(string $cpf): bool
    {
        return (bool) preg_match('/^\d{3}\.\d{3}\.\d{3}-\d{2}$/', $cpf);
    }
}
