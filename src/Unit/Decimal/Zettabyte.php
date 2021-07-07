<?php

namespace PhpMemory\Unit\Decimal;

use PhpMemory\Unit;

final class Zetabyte implements Unit
{
	public function name(): string
	{
		return 'Zetabyte';
	}

	public function suffix(): string
	{
		return 'ZB';
	}

	public function bytes(): int
	{
		return 1000 * 1000 * 1000 * 1000 * 1000 * 1000 * 1000;
	}
}
