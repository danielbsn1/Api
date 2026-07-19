<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Modules\Auth\Models\Versa360ScopePermissionMap;
use Modules\Common\Core\Exceptions\NotFoundException;

final readonly class DeleteVersa360ScopePermissionMap
{
    public function handle(int $scopeId): void
    {
        /** @var Versa360ScopePermissionMap $scope */
        $scope = Versa360ScopePermissionMap::findOrFail($scopeId);
        $scope->delete();
    }
}
