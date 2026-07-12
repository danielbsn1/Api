<?php

declare(strict_types=1);

namespace Modules\Common\Core\Policies;

use Modules\Common\Core\Enums\Role;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

abstract class BasePolicy
{
    use HandlesAuthorization;

    public function viewAny(Model $user): bool
    {
        return $user->role?->canView() ?? false;
    }

    public function view(Model $user, Model $resource): bool
    {
        return $user->role?->canView() ?? false;
    }

    public function create(Model $user): bool
    {
        return $user->role?->canEdit() ?? false;
    }

    public function update(Model $user, Model $resource): bool
    {
        return $user->role?->canEdit() ?? false;
    }

    public function delete(Model $user, Model $resource): bool
    {
        return $user->role?->canDelete() ?? false;
    }

    protected function isAdmin(Model $user): bool
    {
        return $user->role === Role::ADMIN;
    }

    protected function isRhManager(Model $user): bool
    {
        return in_array($user->role, [Role::ADMIN, Role::RH_MANAGER]);
    }

    protected function isSameUser(Model $user, Model $resource): bool
    {
        return $user->id === $resource->id;
    }

    protected function isManagerOf(Model $user, Model $resource): bool
    {
        return $user->role === Role::MANAGER
            && $user->department_id === $resource->department_id;
    }

    protected function belongsToSameCompany(Model $user, Model $resource): bool
    {
        return $user->company_id === $resource->company_id;
    }

    protected function canAccessResource(Model $user, Model $resource): bool
    {
        if (!$this->belongsToSameCompany($user, $resource)) {
            return false;
        }

        return $user->role?->canView() ?? false;
    }
}
