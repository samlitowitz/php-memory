<?php

namespace PhpMemory\Unit\Decimal;

use PhpMemory\Unit;

final class Megabyte implements Unit
{
	public function name(): string
	{
		return 'Megabyte';
	}

	public function suffix(): string
	{
		return 'MB';
	}

	public function bytes(): int
	{
		return 1000 * 1000;
	}
}
