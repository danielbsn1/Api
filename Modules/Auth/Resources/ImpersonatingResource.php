<?php

declare(strict_types=1);

namespace Modules\Auth\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class ImpersonatingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'type' => $this->resource['type'],
            'token' => $this->resource['token'],
            'is_impersonating' => $this->resource['is_impersonating'],
            'impersonator' => new UserResource($this->resource['impersonator']),
            'impersonated' => new UserResource($this->resource['impersonated']),
        ];
    }
}
