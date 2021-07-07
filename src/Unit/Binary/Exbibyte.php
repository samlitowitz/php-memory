<?php

namespace PhpMemory\Unit\Binary;

use PhpMemory\Unit;

final class Exbibyte implements Unit
{
	public function name(): string
	{
		return 'Exbibyte';
	}

	public function suffix(): string
	{
		return 'EiB';
	}

	public function bytes(): int
	{
		return 1024 * 1024 * 1024 * 1024 * 1024 * 1024;
	}
}
