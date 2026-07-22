<?php

declare(strict_types=1);

namespace Modules\Auth\DTOs;

use Illuminate\Validation\Rules\Password;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

final class NewPasswordDTO extends ValidatedDTO
{
    public string $token;

    public string $login;

    public string $password;

    protected function rules(): array
    {
        return [
            'token' => ['required', 'string'],
            'login' => ['required', 'string'],
            'password' => [
                'required',
                Password::min(8)
                    ->max(255)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
                'confirmed',
            ],
        ];
    }

    protected function defaults(): array
    {
        return [];
    }

    protected function casts(): array
    {
        return [];
    }
}
