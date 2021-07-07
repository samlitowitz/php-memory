<?php

namespace PhpMemory;

final class Size
{
	/** @var int */
	private $value;
	/** @var Unit */
	private $unit;

	private function __construct(int $value, Unit $unit)
	{
		$this->value = $value;
		$this->unit = $unit;
	}

	public static function create(int $value, Unit $unit): Size
	{
		$size = new Size(0, $unit);
		$size->set_value($value);
		return $size;
	}

	public function getBytes(): int
	{
		return $this->value * $this->unit->bytes();
	}

	public function getValue(): int
	{
		return $this->value;
	}

	public function setValue(int $value): void
	{
		if ($value < 0) {
			throw new InvalidArgumentException('size must be a positive integer');
		}
		$this->value = $value;
	}

	public function getUnit(): Unit
	{
		return $this->unit;
	}

	public function setUnit(Unit $unit): void
	{
		$this->unit = $unit;
	}
}
