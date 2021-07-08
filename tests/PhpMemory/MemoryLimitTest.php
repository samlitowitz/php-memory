<?php

namespace PhpMemory;

use PhpMemory\Unit\Binary\Gigabyte;
use PhpMemory\Unit\Binary\Kilobyte;
use PhpMemory\Unit\Binary\Megabyte;
use PhpMemory\Unit\Byte;
use PHPUnit\Framework\TestCase;

final class MemoryLimitTest extends TestCase
{

	/**
	 * @dataProvider get_with_strings_provider
	 */
	public function test_get_with_strings(string $limit, Size $expected)
	{
		ini_set(MemoryLimit::INI_OPTION, $limit);
		$actual = MemoryLimit::get();

		$this->assertNotNull($actual);
		$this->assertEquals($expected->getValue(), $actual->getValue());
		$this->assertEquals($expected->getUnit()->bytes(), $actual->getUnit()->bytes());
		$this->assertEquals($expected->getBytes(), $actual->getBytes());
	}

	public function get_with_strings_provider()
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

	public function test_get_no_limit()
	{
		ini_set(MemoryLimit::INI_OPTION, -1);
		$actual = MemoryLimit::get();

		$this->assertNull($actual);
	}

	public function test_get_positive_integer()
	{
		$expected = Size::create(100, new Byte());

		ini_set(MemoryLimit::INI_OPTION, 100);
		$actual = MemoryLimit::get();

		$this->assertNotNull($actual);
		$this->assertEquals($expected->getValue(), $actual->getValue());
		$this->assertEquals($expected->getUnit()->bytes(), $actual->getUnit()->bytes());
		$this->assertEquals($expected->getBytes(), $actual->getBytes());
	}

	public function test_get_negative_integer_throws()
	{
		ini_set(MemoryLimit::INI_OPTION, -10);
		$this->expectException(InvalidArgumentException::class);
		MemoryLimit::get();
	}

	public function test_get_invalid_unit_type_throws()
	{
		ini_set(MemoryLimit::INI_OPTION, '1MB');
		$this->expectException(InvalidArgumentException::class);
		MemoryLimit::get();
	}
}
