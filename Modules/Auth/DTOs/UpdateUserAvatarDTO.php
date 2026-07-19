<?php

declare(strict_types=1);

namespace Modules\Auth\DTOs;

use Illuminate\Http\UploadedFile;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

final class UpdateUserAvatarDTO extends ValidatedDTO
{
    public UploadedFile $avatar;

    protected function rules(): array
    {
        return [
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ];
    }

    protected function defaults(): array
    {
        return [];
    }

    protected function casts(): array
    {
        return [
            'avatar' => new \WendellAdriel\ValidatedDTO\Casting\ObjectCast(UploadedFile::class),
        ];
    }
}
