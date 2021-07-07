<?php

namespace PhpMemory;

interface Unit
{
	public function name(): string;

	public function suffix(): string;

	public function bytes(): int;
}
