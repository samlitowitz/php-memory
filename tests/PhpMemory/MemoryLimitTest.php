<?php

namespace PhpMemory;

use PhpMemory\Unit\Binary\Gigabyte;
use PhpMemory\Unit\Binary\Kilobyte;
use PhpMemory\Unit\Binary\Megabyte;
use PhpMemory\Unit\Byte;
use PHPUnit\Framework\TestCase;

final class MemoryLimitTest extends TestCase {

	/**
	 * @dataProvider get_provider
	 */
	public function test_get(string $limit, Size $expected)
	{
		ini_set(MemoryLimit::INI_OPTION, $limit);
		$actual = MemoryLimit::get();

		$this->assertNotNull($actual);
		$this->assertEquals($expected->getValue(), $actual->getValue());
		$this->assertEquals($expected->getUnit()->bytes(), $actual->getUnit()->bytes());
		$this->assertEquals($expected->getBytes(), $actual->getBytes());
	}

	public function get_provider()
	{
		return [
			'integer string bytes' => [
				'100',
				Size::create(100, new Byte()),
			],
			'1K' => [
				'1K',
				Size::create(1, new Kilobyte()),
			],
			'1M' => [
				'1M',
				Size::create(1, new Megabyte()),
			],
			'1G' => [
				'1G',
				Size::create(1, new Gigabyte()),
			],
		];
	}
}
