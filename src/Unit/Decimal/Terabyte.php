<?php

namespace PhpMemory\Unit\Decimal;

use PhpMemory\Unit;

final class Terabyte implements Unit
{
	public function name(): string
	{
		return 'Terabyte';
	}

	public function suffix(): string
	{
		return 'TB';
	}

	public function bytes(): int
	{
		return 1000 * 1000 * 1000 * 1000;
	}
}
