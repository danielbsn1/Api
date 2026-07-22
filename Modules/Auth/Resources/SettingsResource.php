<?php

declare(strict_types=1);

namespace Modules\Auth\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class SettingsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'auth' => $this->resource['auth'],
        ];
    }
}
