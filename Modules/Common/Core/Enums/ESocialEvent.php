<?php

declare(strict_types=1);

namespace Modules\Common\Core\Enums;

enum ESocialEvent: string
{
    // Eventos Iniciais
    case S1000 = 'S-1000';
    case S1005 = 'S-1005';
    case S1020 = 'S-1020';
    case S1030 = 'S-1030';
    case S1050 = 'S-1050';
    case S1070 = 'S-1070';

    // Eventos Não Periódicos
    case S2200 = 'S-2200';
    case S2205 = 'S-2205';
    case S2206 = 'S-2206';
    case S2230 = 'S-2230';
    case S2299 = 'S-2299';
    case S2300 = 'S-2300';

    // Eventos Periódicos
    case S1200 = 'S-1200';
    case S1210 = 'S-1210';
    case S1299 = 'S-1299';

    // SST
    case S2210 = 'S-2210';
    case S2220 = 'S-2220';
    case S2240 = 'S-2240';




public function description(): string
{
    return match ($this) {
        self::S1000 => 'Informações do Empregador',
        self::S1005 => 'Tabela de Estabelecimentos',
        self::S1020 => 'Tabela de Lotações Tributárias',
        self::S1030 => 'Tabela de Cargos',
        self::S1050 => 'Tabela de Horários',
        self::S1070 => 'Tabela de Processos',

        self::S2200 => 'Admissão',
        self::S2205 => 'Alteração Cadastral',
        self::S2206 => 'Alteração Contratual',
        self::S2230 => 'Afastamento',
        self::S2299 => 'Desligamento',
        self::S2300 => 'Sem Vínculo',

        self::S1200 => 'Remuneração',
        self::S1210 => 'Pagamento',
        self::S1299 => 'Fechamento',

        self::S2210 => 'CAT',
        self::S2220 => 'ASO',
        self::S2240 => 'Condições Ambientais',
    };
}

public static function initial(): array
{
    return [
        self::S1000,
        self::S1005,
        self::S1020,
        self::S1030,
        self::S1050,
        self::S1070,
    ];
}

public static function nonPeriodic(): array
{
    return [
        self::S2200,
        self::S2205,
        self::S2206,
        self::S2230,
        self::S2299,
        self::S2300,
    ];
}

public static function periodic(): array
{
    return [
        self::S1200,
        self::S1210,
        self::S1299,
    ];
}

public static function sst(): array
{
    return [
        self::S2210,
        self::S2220,
        self::S2240,
    ];
}
}