<?php declare(strict_types=1);

namespace Tests\Integration\Setters\Contracts;

class ValueSetterClass
{
    public static function sum(int $n1, int $n2): int
    {
        return $n1 + $n2;
    }

    public static function string(string $value)
    {
        return $value;
    }
}
