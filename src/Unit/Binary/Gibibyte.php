<?php

namespace PhpMemory\Unit\Binary;

use PhpMemory\Unit;

final class Gibibyte implements Unit
{
	public function name(): string
	{
		return 'Gibibyte';
	}

	public function suffix(): string
	{
		return 'GiB';
	}

	public function bytes(): int
	{
		return 1024 * 1024 * 1024;
	}
}
