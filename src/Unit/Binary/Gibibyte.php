<?php

namespace PhpMemory\Unit\Binary;

use PhpMemory\Unit;

final class Gibibyte implements Unit
{
    public function name(): string
    {
        return 'Gibibyte';
    }

    public function binaryPrefix(): string
    {
        return 'GiB';
    }

    public function memoryLimitSuffix(): string
    {
        return 'G';
    }
    public function bytes(): int
    {
        return 1024 * 1024 * 1024;
    }
}
