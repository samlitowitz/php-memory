<?php

namespace PhpMemory\Unit;

use PhpMemory\Unit;

final class Byte implements Unit
{
    public function name(): string
    {
        return 'Byte';
    }

    public function binaryPrefix(): string
    {
        return 'B';
    }

    public function memoryLimitSuffix(): string
    {
        return '';
    }

    public function bytes(): int
    {
        return 1;
    }
}
