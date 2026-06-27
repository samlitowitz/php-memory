<?php

namespace PhpMemory;

interface Unit
{
    public function name(): string;

    public function binaryPrefix(): string;

    public function memoryLimitSuffix(): string;

    public function bytes(): int;
}
