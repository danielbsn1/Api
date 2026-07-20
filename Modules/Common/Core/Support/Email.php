<?php

declare(strict_types=1);

namespace Modules\Common\Core\Support\Contact;

final readonly class Email
{
    public static function normalize(string $email): string
    {
        return mb_strtolower(trim($email));
    }

    public static function validate(string $email): bool
    {
        return filter_var(
            self::normalize($email),
            FILTER_VALIDATE_EMAIL
        ) !== false;
    }

    public static function domain(string $email): string
    {
        return substr(
            self::normalize($email),
            strpos(self::normalize($email), '@') + 1
        );
    }

    public static function localPart(string $email): string
    {
        return strstr(self::normalize($email), '@', true);
    }
}