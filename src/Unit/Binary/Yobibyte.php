<?php

namespace PhpMemory\Unit\Binary;

use PhpMemory\Unit;

final class Yobibyte implements Unit
{
	public function name(): string
	{
		return 'Yobibyte';
	}

	public function suffix(): string
	{
		return 'YiB';
	}

	public function bytes(): int
	{
		return 1024 * 1024 * 1024 * 1024 * 1024 * 1024 * 1024 * 1024;
	}
}
