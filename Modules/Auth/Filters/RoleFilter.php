<?php

declare(strict_types=1);

namespace Modules\Auth\Filters;

use Illuminate\Database\Eloquent\Builder;
use Modules\Common\Core\Filters\Abstracts\Filter;

class RolesFilter extends Filter
{
    public function apply(Builder $builder, mixed $value, string $filter): Builder
    {
        $roles = request()->string('roles')->explode(',');

        $roles->each(function (string $role) use ($builder) {
            $builder->whereHas('roles', function (Builder $query) use ($role) {
                $query->where('name', $role);
            });
        });

        return $builder;
    }
}
