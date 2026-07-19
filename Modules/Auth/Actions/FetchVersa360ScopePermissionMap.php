<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Modules\Auth\Models\Versa360ScopePermissionMap;
use Modules\Common\Core\Exceptions\NotFoundException;

final readonly class FetchVersa360ScopePermissionMap
{
    public function handle(int $scopeId): Versa360ScopePermissionMap
    {
        /** @var Versa360ScopePermissionMap $scope */
        $scope = Versa360ScopePermissionMap::findOrFail($scopeId);

        return $scope;
    }
}
