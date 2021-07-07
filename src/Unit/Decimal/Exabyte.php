<?php

namespace PhpMemory\Unit\Decimal;

use PhpMemory\Unit;

final class Exabyte implements Unit
{
	public function name(): string
	{
		return 'Exabyte';
	}

	public function suffix(): string
	{
		return 'EB';
	}

	public function bytes(): int
	{
		return 1000 * 1000 * 1000 * 1000 * 1000 * 1000;
	}
}
