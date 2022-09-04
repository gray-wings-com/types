<?php
declare(strict_types=1);

namespace Graywings\Types\Str;

use Graywings\Types\Type;

abstract class Str implements Type
{
    protected string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public static function new(
        string $value = '',
        string $encoding = 'utf-8'
    ): self
    {
        if (strlen($value) !== mb_strlen($value)) {
            return new MultiBytesString($value, $encoding);
        } else {
            return new AsciiString($value);
        }
    }

    abstract public function length(): int;
}
