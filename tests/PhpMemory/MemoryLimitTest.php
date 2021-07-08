<?php

namespace PhpMemory;

use PhpMemory\Unit\Binary\Gibibyte;
use PhpMemory\Unit\Binary\Gigabyte;
use PhpMemory\Unit\Binary\Kibibyte;
use PhpMemory\Unit\Binary\Kilobyte;
use PhpMemory\Unit\Binary\Mebibyte;
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

	/**
	 * @dataProvider set_as_bytes_provider
	 */
	public function test_set_as_bytes(Size $expected)
	{
		MemoryLimit::set($expected);
		$actual = MemoryLimit::get();

		$this->assertNotNull($actual);
		$this->assertEquals($expected->getBytes(), $actual->getBytes());
	}

	public function set_as_bytes_provider()
	{
		return [
			'100 bytes' => [
				Size::create(100, new Byte()),
			],
			'1 kibibyte' => [
				Size::create(1, new Kibibyte()),
			],
			'1 kilobyte' => [
				Size::create(1, new Kilobyte()),
			],
			'1 mebibyte' => [
				Size::create(1, new Mebibyte()),
			],
			'1 megabyte' => [
				Size::create(1, new Megabyte()),
			],
			'1 gibibyte' => [
				Size::create(1, new Gibibyte()),
			],
			'1 gigabyte' => [
				Size::create(1, new Gigabyte()),
			],
		];
	}

	/**
	 * @dataProvider set_as_string_provider
	 */
	public function test_set_as_string(Size $size, string $expected)
	{
		MemoryLimit::set($size, true);
		$actual = ini_get(MemoryLimit::INI_OPTION);

		$this->assertNotNull($actual);
		$this->assertNotFalse($actual);
		$this->assertEquals($expected, $actual);
	}

	public function set_as_string_provider()
	{
		return [
			'100 bytes' => [
				Size::create(100, new Byte()),
				'100',
			],
			'1 kibibyte' => [
				Size::create(1, new Kibibyte()),
				'1K',
			],
			'1 kilobyte' => [
				Size::create(1, new Kilobyte()),
				'1K',
			],
			'1 mebibyte' => [
				Size::create(1, new Mebibyte()),
				'1M',
			],
			'1 megabyte' => [
				Size::create(1, new Megabyte()),
				'1M',
			],
			'1 gibibyte' => [
				Size::create(1, new Gibibyte()),
				'1G',
			],
			'1 gigabyte' => [
				Size::create(1, new Gigabyte()),
				'1G',
			],
		];
	}

	public function test_set_no_limit()
	{
		MemoryLimit::set(null);
		$actual = MemoryLimit::get();

		$this->assertNull($actual);
	}

}
