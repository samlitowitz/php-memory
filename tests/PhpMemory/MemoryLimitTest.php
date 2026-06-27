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
use Throwable;

final class MemoryLimitTest extends TestCase
{
    /**
     * @dataProvider withStringsProvider
     */
    public function testWithStrings(Unit $unit): void
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

    public function withStringsProvider(): array
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
        $expected = $this->minimumSizeGreaterThan(
            memory_get_usage(),
            new Byte()
        );

        ini_set(MemoryLimit::INI_OPTION, $expected->getBytes());
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
        $expected = $this->minimumSizeGreaterThan(
            memory_get_usage(),
            new Byte()
        );
        $limit = sprintf(
            '%d%s',
            $expected->getValue(),
            (new Megabyte())->binaryPrefix()
        );
        try {
            ini_set(MemoryLimit::INI_OPTION, $limit);
        } catch (Throwable $t) {
            $this->assertNotEmpty($t);
        }
        $this->expectException(InvalidArgumentException::class);
        MemoryLimit::get();
    }

    /**
     * @dataProvider setAsBytesProvider
     */
    public function testSetAsBytes(Unit $unit): void
    {
        $expected = $this->minimumSizeGreaterThan(
            memory_get_usage(),
            $unit
        );

        MemoryLimit::set($expected);
        $actual = MemoryLimit::get();

        $this->assertNotNull($actual);
        $this->assertEquals($expected->getBytes(), $actual->getBytes());
    }

    public function setAsBytesProvider(): array
    {
        return [
            'bytes' => [
                new Byte(),
            ],
            'kibibyte' => [
                new Kibibyte(),
            ],
            'kilobyte' => [
                new Kilobyte(),
            ],
            'mebibyte' => [
                new Mebibyte(),
            ],
            'megabyte' => [
                new Megabyte(),
            ],
            'gibibyte' => [
                new Gibibyte(),
            ],
            'gigabyte' => [
                new Gigabyte(),
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
