<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

final readonly class Refresh
{
    private const TOKEN_TYPE = 'Bearer';

    public function handle(): array
    {
        $token = Auth::guard('api')->refresh();
        if (! $token) {
            throw new AuthenticationException();
        }

        return [
            'type' => self::TOKEN_TYPE,
            'token' => $token,
        ];
    }
}