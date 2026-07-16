<?php

declare(strict_types=1);

namespace Modules\Auth\DTOs;

use Illuminate\Validation\Rules\Password;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class ChangeUserPasswordDTO extends ValidatedDTO
{
    public string $password;

    protected function rules(): array
    {
        return [
            'password' => [
                'required',
                Password::min(5)->max(255),
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
