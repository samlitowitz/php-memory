<?php

namespace PhpMemory\Unit\Decimal;

use PhpMemory\Unit;

final class Kilobyte implements Unit
{
	public function name(): string
	{
		return 'Kilobyte';
	}

	public function suffix(): string
	{
		return 'kB';
	}

	public function bytes(): int
	{
		return 1000;
	}
}
