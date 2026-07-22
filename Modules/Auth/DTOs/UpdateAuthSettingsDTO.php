<?php

declare(strict_types=1);

namespace Modules\Auth\DTOs;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class UpdateAuthSettingsDTO extends ValidatedDTO
{
    public bool $redirect_on_first_login;

    public ?string $redirect_on_first_login_path;

    public bool $force_change_password_on_first_login;

    protected function rules(): array
    {
        return [
            'redirect_on_first_login' => ['sometimes', 'boolean'],
            'redirect_on_first_login_path' => ['sometimes', 'nullable', 'string'],
            'force_change_password_on_first_login' => ['sometimes', 'boolean'],
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
