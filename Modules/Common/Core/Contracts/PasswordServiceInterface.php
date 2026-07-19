<?php

declare(strict_types=1);

namespace Modules\Common\Core\Contracts;

interface PasswordServiceInterface
{
    public function hash(string $password): string;

    public function verify(string $password, string $hash): bool;

    public function isStrong(string $password): bool;

    public function generateReset(string $email): string;

    public function validateReset(string $token): bool;
}
