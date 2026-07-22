<?php

declare(strict_types=1);

namespace Modules\Auth\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class PermissionModuleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'modules' => $this->resource['modules'],
        ];
    }
}
