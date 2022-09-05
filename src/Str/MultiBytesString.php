<?php
declare(strict_types=1);

namespace Graywings\Types\Str;

use Graywings\Exceptions\LogicExceptions\LogicInvalidTypeException;
use Graywings\Exceptions\LogicExceptions\LogicRangeException;
use Graywings\Types\Type;

class MultiBytesString extends Str
{
    private string $encoding;
    public function __construct(
        string $value = '',
        string $encoding = 'utf-8'
    )
    {
        if (strlen($value) === 0 || strlen($value) !== mb_strlen($value)) {
            parent::__construct($value);
            $this->encoding = $encoding;
        } else {
            throw new LogicRangeException('The argument given does not contain multi bytes character.');
        }
    }

    public static function cast(object $target): self
    {
        if (!$target instanceof self) {
            throw new LogicInvalidTypeException('A not MultiBytesString argument is given.');
        }
        return $target;
    }

    public function equals(Type $other): bool
    {
        return $this->value === self::cast($other)->value();
    }

    public function length(): int
    {
        return mb_strlen($this->value, $this->encoding);
    }
}
