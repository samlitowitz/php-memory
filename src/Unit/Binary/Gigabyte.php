<?php

namespace PhpMemory\Unit\Binary;

use PhpMemory\Unit;

final class Gigabyte implements Unit
{
    public function name(): string
    {
        return 'Gigabyte';
    }

    public function binaryPrefix(): string
    {
        return 'GB';
    }

    public function memoryLimitSuffix(): string
    {
        return 'G';
    }
    public function bytes(): int
    {
        return (new Gibibyte())->bytes();
    }
}
