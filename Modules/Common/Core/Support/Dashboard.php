<?php

declare(strict_types=1);

namespace Modules\Common\Core\Support;

use Illuminate\Database\Eloquent\Builder;
use Modules\Common\Core\DTOs\DashboardDTO;

readonly class Dashboard
{
    public static function applyDateRangeFilter(Builder $builder, DashboardDTO $dto, string $dateField = 'created_at'): Builder
    {
        if (! empty($dto->start_date)) {
            $builder->where($dateField, '>=', $dto->start_date->startOfDay());
        }

        if (! empty($dto->end_date)) {
            $builder->where($dateField, '<=', $dto->end_date->endOfDay());
        }

        return $builder;
    }

    public static function calculateGrowthRate(int $current, int $previous): float
    {
        if ($previous === 0) {
            return 0;
        }

        return (($current - $previous) / $previous) * 100;
    }
}
