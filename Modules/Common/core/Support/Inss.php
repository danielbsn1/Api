<?php

declare(strict_types=1);

namespace Modules\Common\Core\Support;

final class Inss
{
    private const TABELA = [
        ['limite' => 141200,  'aliquota' => 7.5],
        ['limite' => 266668,  'aliquota' => 9.0],
        ['limite' => 400003,  'aliquota' => 12.0],
        ['limite' => 778602,  'aliquota' => 14.0],
    ];

    public static function calcular(Money $salario): Money
    {
        $centavos = (int) round($salario->toFloat() * 100);
        $inss = 0;
        $faixaAnterior = 0;

        foreach (self::TABELA as $faixa) {
            if ($centavos <= $faixaAnterior) break;

            $base = min($centavos, $faixa['limite']) - $faixaAnterior;
            $inss += (int) round($base * $faixa['aliquota'] / 100);
            $faixaAnterior = $faixa['limite'];
        }

        return Money::fromFloat($inss / 100);
    }
}