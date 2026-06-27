<?php

namespace PhpMemory\Unit\Binary;

use PhpMemory\Unit;

final class Kilobyte implements Unit
{
    public function name(): string
    {
        return 'Kilobyte';
    }

    public function binaryPrefix(): string
    {
        return 'KB';
    }

    public function memoryLimitSuffix(): string
    {
        return 'K';
    }
    public function bytes(): int
    {
        return (new Kibibyte())->bytes();
    }
}
