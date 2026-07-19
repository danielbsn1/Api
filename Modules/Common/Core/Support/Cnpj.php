<?php

declare(strict_types=1);

namespace Modules\Common\Core\Support\Documents;

final readonly class Cnpj
{
    private const LENGTH = 14;

    public static function format(string $cnpj): string
    {
        $cnpj = self::unformat($cnpj);

        return substr($cnpj, 0, 2).'.'.substr($cnpj, 2, 3).'.'.substr($cnpj, 5, 3).'/'.substr($cnpj, 8, 4).'-'.substr($cnpj, 12, 2);
    }

    public static function unformat(string $cnpj): string
    {
        return preg_replace('/\D/', '', $cnpj);
    }

    public static function validate(string $cnpj): bool
    {
        $cnpj = self::unformat($cnpj);

        if (strlen($cnpj) !== self::LENGTH || preg_match('/^(\d)\1+$/', $cnpj)) {
            return false;
        }

        for ($t = 12; $t < 14; $t++) {
            $sum = 0;
            for ($i = 0; $i < $t; $i++) {
                $sum += (int) $cnpj[$i] * ($t + 1 - $i);
            }
            $remainder = (($sum * 10) % 11) % 10;
            if ((int) $cnpj[$t] !== $remainder) {
                return false;
            }
        }

        return true;
    }

    public static function isFormatted(string $cnpj): bool
    {
        return (bool) preg_match('/^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/', $cnpj);
    }
}
