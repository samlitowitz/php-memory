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
    public function testGetWithStrings(Unit $unit): void
    {
        $expected = $this->minimumSizeGreaterThan(
            memory_get_usage(),
            $unit
        );

        ini_set(MemoryLimit::INI_OPTION, $this->toMemoryLimitShorthand($expected));
        $actual = MemoryLimit::get();

        $this->assertNotNull($actual);
        $this->assertEquals($expected->getValue(), $actual->getValue());
        $this->assertEquals($expected->getUnit()->bytes(), $actual->getUnit()->bytes());
        $this->assertEquals($expected->getBytes(), $actual->getBytes());
    }

    public function getWithStringsProvider(): array
    {
        return [
            'bytes' => [
                new Byte(),
            ],
            'K' => [
                new Kilobyte(),
            ],
            'M' => [
                new Megabyte(),
            ],
            'G' => [
                new Gigabyte(),
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
        // avoid attempting to set memory limit lower than current usage
        $current_memory_usage_in_bytes = memory_get_usage();
        if ($expected->getBytes() <= $current_memory_usage_in_bytes) {
            // get unit bytes, add fuzz factor to expected to
        }

        MemoryLimit::set($expected);
        $actual = MemoryLimit::get();

        $this->assertNotNull($actual);
        $this->assertEquals($expected->getBytes(), $actual->getBytes());
    }

    public function setAsBytesProvider(): array
    {
        return [
            '1 bytes' => [
                Size::create(1, new Byte()),
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

    private function minimumSizeGreaterThan(int $memoryInBytes, Unit $unit, float $safetyMargin = 3): Size
    {
        $memoryInBytesWithSafetyMargin = $memoryInBytes * $safetyMargin;
        $minimumSizeInUnit = ceil($memoryInBytesWithSafetyMargin / $unit->bytes());
        return Size::create(
            intval($minimumSizeInUnit),
            $unit
        );
    }

    private function toMemoryLimitShorthand(Size $size): string
    {
        return sprintf('%d%s', $size->getValue(), $size->getUnit()->memoryLimitSuffix());
    }
}
