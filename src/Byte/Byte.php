<?php
declare(strict_types=1);

namespace Graywings\Types\Byte;

use Graywings\Exceptions\LogicExceptions\DomainException;

class Byte
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
}
