<?php

declare(strict_types=1);

namespace Modules\Common\Core\Support;

enum DashboardElementType: string
{
    case NUMBER_CARD = 'NumberCard';
    case BAR_CHART_CARD = 'BarChartCard';
    case TABLE_CARD = 'TableCard';

    public static function all(): array
    {
        return [
            self::NUMBER_CARD,
            self::BAR_CHART_CARD,
            self::TABLE_CARD,
        ];
    }

    public static function toArray(): array
    {
        return array_column(DashboardElementType::cases(), 'value');
    }

    public function description(): string
    {
        return match ($this) {
            self::NUMBER_CARD => 'Valor numérico',
            self::BAR_CHART_CARD => 'Gráfico de barras',
            self::TABLE_CARD => 'Tabela',
        };
    }
}
