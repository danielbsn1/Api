<?php

declare(strict_types=1);

namespace Modules\Common\Core\DTOs;

use Illuminate\Http\Request;

abstract class BaseDTO
{
    abstract public static function fromRequest(Request $request): static;

    abstract public function toArray(): array;

    public static function fromArray(array $data): static
    {
        $request = new Request($data);

        return static::fromRequest($request);
    }
}
