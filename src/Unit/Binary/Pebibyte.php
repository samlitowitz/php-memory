<?php

namespace PhpMemory\Unit\Binary;

use PhpMemory\Unit;

final class Pebibyte implements Unit
{
	public function name(): string
	{
		return 'Pebibyte';
	}

	public function suffix(): string
	{
		return 'PiB';
	}

	public function bytes(): int
	{
		return 1024 * 1024 * 1024 * 1024 * 1024;
	}
}
