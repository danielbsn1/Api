<?php

declare(strict_types=1);

namespace Modules\Auth\DTOs;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

final class EnableTwoFactorDTO extends ValidatedDTO
{
    public string $secret;

    public string $qr_code_url;

    protected function rules(): array
    {
        return [
            'secret' => ['required', 'string'],
            'qr_code_url' => ['required', 'string'],
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
