<?php

declare(strict_types=1);

use WendellAdriel\ValidatedDTO\ValidatedDTO;

final class ConfirmTwoFactorDTO extends ValidatedDTO
{
    public string $code;

    protected function rules(): array
    {
        return [
            'code' => ['required', 'string'],
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
