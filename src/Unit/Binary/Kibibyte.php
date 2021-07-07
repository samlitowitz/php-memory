<?php

namespace PhpMemory\Unit\Binary;

use PhpMemory\Unit;

final class Kibibyte implements Unit
{
	public function name(): string
	{
		return 'Kibibyte';
	}

	public function suffix(): string
	{
		return 'KiB';
	}

	public function bytes(): int
	{
		return 1024;
	}
}
