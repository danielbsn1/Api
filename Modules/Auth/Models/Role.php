<?php

declare(strict_types=1);

namespace Modules\Auth\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Auth\Exceptions\ProtectedRoleException;
use Modules\Common\Core\Enums\DefaultRole;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected $guard_name = 'api';

    protected $nullable = ['description'];

    public static function nullable(): array
    {
        return (new self)->nullable;
    }

    public function isProtected(): bool
    {
        return in_array(
            $this->name,
            array_map(fn (DefaultRole $role) => $role->value, DefaultRole::hidden())
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
            fn (Builder $builder) => $builder->whereNotIn('name', array_map(fn (DefaultRole $role) => $role->value, DefaultRole::hidden()))
        );
    }
}
