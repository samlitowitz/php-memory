<?php

namespace PhpMemory\Unit\Binary;

use PhpMemory\Unit;

final class Kibibyte implements Unit
{
    public function name(): string
    {
        return 'Kibibyte';
    }

    public function binaryPrefix(): string
    {
        return 'KiB';
    }

    public function memoryLimitSuffix(): string
    {
        return 'K';
    }
    public function bytes(): int
    {
        return 1024;
    }
}
