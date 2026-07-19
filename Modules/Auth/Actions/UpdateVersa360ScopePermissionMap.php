<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Modules\Auth\DTOs\UpdateVersa360ScopePermissionMapDTO;
use Modules\Auth\Models\Versa360ScopePermissionMap;
use Modules\Common\Core\Exceptions\NotFoundException;

final readonly class UpdateVersa360ScopePermissionMap
{
    public function handle(int $scopeId, UpdateVersa360ScopePermissionMapDTO $dto): Versa360ScopePermissionMap
    {
        /** @var Versa360ScopePermissionMap $scope */
        $scope = Versa360ScopePermissionMap::findOrFail($scopeId);

        $scope->fill($dto->validated());
        $scope->save();

        return $scope;
    }
}
