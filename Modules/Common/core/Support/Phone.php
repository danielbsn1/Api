<?php

declare(strict_types=1);

namespace Modules\Common\Core\Support\Documents;

final readonly class Phone
{
    private const LENGTH = 10;

    public static function format(string $phone): string
    {
        $phone = self::unformat($phone);
        return '(' . substr($phone, 0, 2) . ') ' . substr($phone, 2, 4) . '-' . substr($phone, 6, 4);
    }

    public static function unformat(string $phone): string
    {
        return preg_replace('/\D/', '', $phone);
    }

    public static function validate(string $phone): bool
    {
        $phone = self::unformat($phone);

        if (strlen($phone) !== self::LENGTH) {
            return false;
        }

        return true;
    }

    public static function isFormatted(string $phone): bool
    {
        return (bool) preg_match('/^\(\d{2}\) \d{4}-\d{4}$/', $phone);
    }
}