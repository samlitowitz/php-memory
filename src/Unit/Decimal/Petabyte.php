<?php

namespace PhpMemory\Unit\Decimal;

use PhpMemory\Unit;

final class Petabyte implements Unit
{
	public function name(): string
	{
		return 'Petabyte';
	}

	public function suffix(): string
	{
		return 'PB';
	}

	public function bytes(): int
	{
		return 1000 * 1000 * 1000 * 1000 * 1000;
	}
}
