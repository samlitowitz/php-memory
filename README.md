# PHP Memory
## Table of Contents
1. [Installation](#installation)
1. [Usage](#usage)

## Installation
```shell
composer require samlitowitz/php-memory
```

## Usage

```php
use PhpMemory\MemoryLimit;
use PhpMemory\Unit\Binary\Megabyte;
MemoryLimit::set(Size::create(2, new Megabyte()), true);

echo init_get(MemoryLimit::INI_OPTION);
// 1M
```

```php
use PhpMemory\MemoryLimit;
use PhpMemory\Unit\Byte;
MemoryLimit::set(Size::create(100, new Byte()));

echo init_get(MemoryLimit::INI_OPTION);
// 100
```

See [MemoryLimitTest](tests/PhpMemory/MemoryLimitTest.php) for more examples.
