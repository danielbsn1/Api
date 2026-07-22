<?php

declare(strict_types=1);

namespace Modules\Common\Core\Filters;

use Illuminate\Database\Eloquent\Builder;
use Modules\Common\Core\Filters\Abstracts\Filter;

final class ActiveFilter extends Filter
{
    public function apply(Builder $builder, mixed $value, string $filter): Builder
    {
        $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);

        return $builder->where('active', $value);
    }
}
