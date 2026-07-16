<?php

declare(strict_types=1);

namespace Modules\Auth\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Modules\Common\Core\Enums\Role as RoleEnum;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected $nullable = ['description'];

    public static function nullable(): array
    {
        return (new self)->nullable;
    }

    public function isProtected(): bool
    {
        return in_array(
            $this->name,
            array_map(fn (RoleEnum $role) => $role->value, Roles::hidden())
        );
    }

    protected static function booted(): void
    {
        static::deleting(function (self $role) {
            if ($role->isProtected()) {
                throw new ProtectedRoleException;
            }
        });

        static::addGlobalScope(
            'hidden',
            fn (Builder $builder) => $builder->whereNotIn('name', RoleEnum::hidden())
        );
    }
}
