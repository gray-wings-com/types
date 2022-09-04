<?php
declare(strict_types=1);

namespace Graywings\Types\Byte;

use Graywings\Exceptions\LogicExceptions\DomainException;
use Graywings\Exceptions\LogicExceptions\InvalidArgumentException;
use Graywings\Types\Type;

class Byte implements Type
{
    private int $value;

    public function __construct(
        int $value = 0
    )
    {
        if ($value > 255 || $value < 0) {
            throw new DomainException($value . ' is not byte value.');
        }
        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }

    public static function cast(object $target): self
    {
        if (!$target instanceof self) {
            throw new InvalidArgumentException('A not Byte argument is given.');
        }
        return $target;
    }

    public function equals(Type $other): bool
    {
        return $this->value === self::cast($other)->value();
    }

    public function __toString(): string
    {
        return '0x' . str_pad(dechex($this->value), 2, '0', STR_PAD_LEFT);
    }

    public function __clone()
    {
    }
}
