<?php

namespace PhpMemory;

use PhpMemory\Unit\Binary\Gibibyte;
use PhpMemory\Unit\Binary\Gigabyte;
use PhpMemory\Unit\Binary\Kibibyte;
use PhpMemory\Unit\Binary\Kilobyte;
use PhpMemory\Unit\Binary\Mebibyte;
use PhpMemory\Unit\Binary\Megabyte;
use PhpMemory\Unit\Byte;

final class MemoryLimit
{
	public const INI_OPTION = 'memory_limit';

	// Returns null there is no limit or the limit is not defined
	public static function get(): ?Size
	{
		$limit = ini_get(self::INI_OPTION);

		if (!is_numeric($limit)) {
			return self::parsePHPShortHand($limit);
		}

		$limit = intval($limit);
		if ($limit === -1) {
			return null;
		}
		return Size::create($limit, new Byte());
	}

	public static function set(?Size $size, bool $asString = false): void
	{
		if ($size === null) {
			ini_set(self::INI_OPTION, -1);
			return;
		}
		if (!$asString) {
			ini_set(self::INI_OPTION, $size->getBytes());
			return;
		}
		ini_set(self::INI_OPTION, self::toPHPShortHand($size));
	}

	private static function toPHPShortHand(Size $size): string
	{
		$unit = $size->getUnit();
		switch (true) {
			case $unit instanceof Byte:
				$shortHandSuffix = '';
				break;
			case $unit instanceof Kilobyte:
			case $unit instanceof Kibibyte:
				$shortHandSuffix = 'K';
				break;
			case $unit instanceof Megabyte:
			case $unit instanceof Mebibyte:
				$shortHandSuffix = 'M';
				break;
			case $unit instanceof Gigabyte:
			case $unit instanceof Gibibyte:
				$shortHandSuffix = 'G';
				break;
			default:
				throw new InvalidArgumentException(sprintf('unsupported unit type `%s`', $unit->name()));
		}
		return sprintf('%d%s', $size->getValue(), $shortHandSuffix);
	}

	private static function parsePHPShortHand(string $limit): Size
	{
		$matched = preg_match('/([0-9]+)([^$]+)/', $limit, $matches);
		if (!$matched) {
			throw new InvalidArgumentException(sprintf('invalid format: `%s`', $limit));
		}

		[
			1 => $value,
			2 => $unit,
		] = $matches;
		switch ($unit) {
			case 'K':
				return Size::create($value, new Kilobyte());
			case 'M':
				return Size::create($value, new Megabyte());
			case 'G':
				return Size::create($value, new Gigabyte());
			default:
				throw new InvalidArgumentException(sprintf('invalid unit: `%s`', $unit));
		}
	}
}
