<?php

declare(strict_types=1);

namespace Modules\Common\Core\Support;

final class Money
{
    private int $cents;

    private function __construct(int $cents)
    {
        $this->cents = $cents;
    }

    public static function fromFloat(float $value): self
    {
        return new self((int) round($value * 100));
    }

    public static function fromString(string $value): self
    {
        $clean = str_replace(['.', 'R$', ' '], '', $value);
        $clean = str_replace(',', '.', $clean);
        return new self((int) round((float) $clean * 100));
    }

    public function toFloat(): float
    {
        return $this->cents / 100;
    }

    public function format(string $currency = 'R$'): string
    {
        return $currency . ' ' . number_format($this->toFloat(), 2, ',', '.');
    }

    public function add(Money $other): self
    {
        return new self($this->cents + $other->cents);
    }

    public function subtract(Money $other): self
    {
        return new self($this->cents - $other->cents);
    }

    public function percentage(float $percent): self
    {
        return new self((int) round($this->cents * $percent / 100));
    }

    public function isGreaterThan(Money $other): bool
    {
        return $this->cents > $other->cents;
    }

    public function equals(Money $other): bool
    {
        return $this->cents === $other->cents;
    }
}
