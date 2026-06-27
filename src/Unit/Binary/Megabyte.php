<?php

namespace PhpMemory\Unit\Binary;

use PhpMemory\Unit;

final class Megabyte implements Unit
{
    public function name(): string
    {
        return 'Megabyte';
    }

    public function binaryPrefix(): string
    {
        return 'MB';
    }

    public function memoryLimitSuffix(): string
    {
        return 'M';
    }

    public function bytes(): int
    {
        return (new Mebibyte())->bytes();
    }
}
