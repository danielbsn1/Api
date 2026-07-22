<?php

declare(strict_types=1);

namespace Modules\Auth\DTOs;

use WendellAdriel\ValidatedDTO\Casting\DTOCast;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class UpdateSettingsDTO extends ValidatedDTO
{
    public ?UpdateAuthSettingsDTO $auth;

    protected function rules(): array
    {
        return [
            'auth' => ['sometimes', 'array'],
        ];
    }

    protected function defaults(): array
    {
        return [];
    }

    protected function casts(): array
    {
        return [
            'auth' => new DTOCast(UpdateAuthSettingsDTO::class),
        ];
    }
}
