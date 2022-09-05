<?php
declare(strict_types=1);

namespace Graywings\Types\Str;

use Graywings\Exceptions\LogicExceptions\LogicInvalidTypeException;
use Graywings\Exceptions\LogicExceptions\LogicRangeException;
use Graywings\Types\Type;

class AsciiString extends Str
{
    public function __construct(
        string $value = ''
    )
    {
        if (strlen($value) === mb_strlen($value)) {
            parent::__construct($value);
        } else {
            throw new LogicRangeException('The argument given is not only ascii character.');
        }
    }

    public static function cast(object $target): self
    {
        if (!$target instanceof self) {
            throw new LogicInvalidTypeException('A not AsciiString argument is given.');
        }
        return $target;
    }

    public function equals(Type $other): bool
    {
        return $this->value === self::cast($other)->value();
    }
}
