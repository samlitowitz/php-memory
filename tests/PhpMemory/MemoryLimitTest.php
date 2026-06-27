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
     * @dataProvider getWithStringsProvider
     */
    public function testGetWithStrings(string $limit, Size $expected): void
    {
        ini_set(MemoryLimit::INI_OPTION, $limit);
        $actual = MemoryLimit::get();

        $this->assertNotNull($actual);
        $this->assertEquals($expected->getValue(), $actual->getValue());
        $this->assertEquals($expected->getUnit()->bytes(), $actual->getUnit()->bytes());
        $this->assertEquals($expected->getBytes(), $actual->getBytes());
    }

    public function getWithStringsProvider(): array
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

    public function testGetNoLimit(): void
    {
        ini_set(MemoryLimit::INI_OPTION, -1);
        $actual = MemoryLimit::get();

        $this->assertNull($actual);
    }

    public function testGetPositiveInteger(): void
    {
        $expected = Size::create(100, new Byte());

        ini_set(MemoryLimit::INI_OPTION, 100);
        $actual = MemoryLimit::get();

        $this->assertNotNull($actual);
        $this->assertEquals($expected->getValue(), $actual->getValue());
        $this->assertEquals($expected->getUnit()->bytes(), $actual->getUnit()->bytes());
        $this->assertEquals($expected->getBytes(), $actual->getBytes());
    }

    public function testGetNegativeIntegerThrows(): void
    {
        ini_set(MemoryLimit::INI_OPTION, -10);
        $this->expectException(InvalidArgumentException::class);
        MemoryLimit::get();
    }

    public function testGetInvalidTypeThrows(): void
    {
        ini_set(MemoryLimit::INI_OPTION, '1MB');
        $this->expectException(InvalidArgumentException::class);
        MemoryLimit::get();
    }

    /**
     * @dataProvider setAsBytesProvider
     */
    public function testSetAsBytes(Size $expected): void
    {
        MemoryLimit::set($expected);
        $actual = MemoryLimit::get();

        $this->assertNotNull($actual);
        $this->assertEquals($expected->getBytes(), $actual->getBytes());
    }

    public function setAsBytesProvider(): array
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
     * @dataProvider setAsStringProvider
     */
    public function testSetAsString(Size $size, string $expected): void
    {
        MemoryLimit::set($size, true);
        $actual = ini_get(MemoryLimit::INI_OPTION);

        $this->assertNotNull($actual);
        $this->assertNotFalse($actual);
        $this->assertEquals($expected, $actual);
    }

    public function setAsStringProvider(): array
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

    public function testSetNoLimits(): void
    {
        MemoryLimit::set(null);
        $actual = MemoryLimit::get();

        $this->assertNull($actual);
    }
}
