<?php

namespace PhpMemory\Unit\Binary;

use PhpMemory\Unit;

final class Mebibyte implements Unit
{
    public function name(): string
    {
        return 'Mebibyte';
    }

    public function binaryPrefix(): string
    {
        return 'MiB';
    }

    public function memoryLimitSuffix(): string
    {
        return 'M';
    }

    public function bytes(): int
    {
        return 1024 * 1024;
    }
}
