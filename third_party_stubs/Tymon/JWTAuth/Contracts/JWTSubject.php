<?php

declare(strict_types=1);

namespace Tymon\JWTAuth\Contracts;

interface JWTSubject
{
    public function getJWTIdentifier();

    public function getJWTCustomClaims(): array;
}
