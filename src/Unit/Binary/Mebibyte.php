<?php

namespace PhpMemory\Unit\Binary;

use PhpMemory\Unit;

final class Mebibyte implements Unit
{
	public function name(): string
	{
		return 'Mebibyte';
	}

	public function suffix(): string
	{
		return 'MiB';
	}

	public function bytes(): int
	{
		return 1024 * 1024;
	}
}
