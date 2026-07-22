<?php

declare(strict_types=1);

namespace Modules\Common\Core\Filters\Abstracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class Filters
{
    protected array $filters = [];

    public function apply(Builder $builder): Builder
    {
        foreach ($this->receivedFilters() as $filter => $value) {
            $builder = $this->resolveFilter($filter)->apply($builder, $value, $filter);
        }

        return $builder;
    }

    protected function resolveFilter(string $filter): Filter
    {
        return new $this->filters[$filter];
    }

    protected function receivedFilters(): array
    {
        return app(Request::class)->only(array_keys($this->filters));
    }
}
