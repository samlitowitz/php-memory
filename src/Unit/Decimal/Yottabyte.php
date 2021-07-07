<?php

namespace PhpMemory\Unit\Decimal;

use PhpMemory\Unit;

final class Yottabyte implements Unit
{
	public function name(): string
	{
		return 'Yottabyte';
	}

	public function suffix(): string
	{
		return 'YB';
	}

	public function bytes(): int
	{
		return 1000 * 1000 * 1000 * 1000 * 1000 * 1000 * 1000 * 1000;
	}
}
