<?php

declare(strict_types=1);

namespace Modules\Common\Core\Filters;

use Illuminate\Database\Eloquent\Builder;
use Modules\Common\Core\Filters\Abstracts\Filter;

final class OrderByFilter extends Filter
{
    public function apply(Builder $builder, mixed $value, string $filter): Builder
    {
        $arr = explode('_', $value);

        $orderable = $builder->orderable ?? [];

        if (array_pop($arr) === 'desc' && in_array($field = implode('_', $arr), $orderable)) {
            return $builder->orderBy($field, 'desc');
        }
        if (in_array($value, $orderable)) {
            return $builder->orderBy($value, 'asc');
        }

        return $builder;
    }
}
