<?php

namespace PhpMemory\Unit;

use PhpMemory\Unit;

final class Byte implements Unit
{
	public function name(): string
	{
		return 'Byte';
	}

	public function suffix(): string
	{
		return 'B';
	}

	public function bytes(): int
	{
		return 1;
	}
}
