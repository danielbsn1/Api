<?php

declare(strict_types=1);

namespace Modules\Auth\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;



final class UserResource extends JsonResource
{
    
    public function toArray(Request $request): array
    {
        $departureAt = $request->query('departure_at');
        $returnAt = $request->query('return_at');

        $this->loadMissing('roles', 'latestLogin');

        $roles = $this->resource->roles ?? collect();
        $data = [
            'id' => $this->uuid,
            'name' => $this->name,
            'login' => $this->login,
            'email' => $this->email,
            'roles' => $roles->pluck('id'),
            'permissions' => $roles->isNotEmpty()
                ? $this->resource->getAllPermissions()->pluck('name')
                : [],
            'active' => $this->active,
            'avatar' => method_exists($this->resource, 'getFirstTemporaryUrl')
                ? ($this->resource->getFirstTemporaryUrl(Carbon::now()->addHours(2), 'avatars', 'large') ?: null)
                : null,
                
            'last_login_at' => optional($this->resource->latestLogin)->created_at,
            'driver' => $this->driver,
            'two_factor_confirmed_at' => $this->two_factor_confirmed_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        if ($departureAt && $returnAt) {
            $data['is_available'] = $this->checkAvailabilityBetween($departureAt, $returnAt);
        }

        return $data;
    }

    private function checkAvailabilityBetween(string $begin, string $end): bool
    {
        if ($this->relationLoaded('vehicleRequestsAsDriver')) {
            return $this->vehicleRequestsAsDriver->isEmpty();
        }

        return ! $this->vehicleRequestsAsDriver()
            ->where('departure_at', '<', $end)
            ->where('return_at', '>', $begin)
            ->exists();
    }
}