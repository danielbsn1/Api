<?php

declare(strict_types=1);

namespace Modules\Common\Core\Contracts;

interface TokenServiceInterface
{
    public function generate(array $payload): string;

    public function validate(string $token): bool;

    public function decode(string $token): array;

    public function refresh(string $token): string;

    public function invalidate(string $token): void;
}
