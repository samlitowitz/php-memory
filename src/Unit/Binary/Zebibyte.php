<?php

namespace PhpMemory\Unit\Binary;

use PhpMemory\Unit;

final class Zebibyte implements Unit
{
	public function name(): string
	{
		return 'Zebibyte';
	}

	public function suffix(): string
	{
		return 'ZiB';
	}

	public function bytes(): int
	{
		return 1024 * 1024 * 1024 * 1024 * 1024 * 1024 * 1024;
	}
}
