<?php

namespace PhpMemory\Unit\Binary;

use PhpMemory\Unit;

final class Tebibyte implements Unit
{
	public function name(): string
	{
		return 'Tebibyte';
	}

	public function suffix(): string
	{
		return 'TiB';
	}

	public function bytes(): int
	{
		return 1024 * 1024 * 1024 * 1024;
	}
}
