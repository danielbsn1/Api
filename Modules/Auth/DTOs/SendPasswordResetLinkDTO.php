<?php

declare(strict_types=1);

namespace Modules\Auth\DTOs;

use Illuminate\Support\Str;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

final class SendPasswordResetLinkDTO extends ValidatedDTO
{
    public string $login;

    public string $callback_url;

    protected function rules(): array
    {
        return [
            'login' => ['required', 'string'],
            'callback_url' => ['nullable', 'url'],
        ];
    }

    protected function defaults(): array
    {
        return [
            'callback_url' => Str::of(tenant()->domains()->first()->domain)
                ->start('https://')
                ->finish('/')
                ->__toString(),
        ];
    }

    protected function casts(): array
    {
        return [
            'callback_url' => fn (string $property, mixed $value) => Str::of($value)
                ->start('https://')
                ->finish('/')
                ->__toString(),
        ];
    }
}
