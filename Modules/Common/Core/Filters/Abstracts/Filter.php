<?php

declare(strict_types=1);

namespace Modules\Common\Core\Filters\Abstracts;

use Illuminate\Database\Eloquent\Builder;

abstract class Filter
{
    abstract public function apply(Builder $builder, mixed $value, string $filter): Builder;
}
