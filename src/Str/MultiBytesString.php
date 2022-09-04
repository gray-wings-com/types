<?php
declare(strict_types=1);

namespace Graywings\Types\Str;

use Graywings\Exceptions\LogicExceptions\DomainException;
use Graywings\Exceptions\LogicExceptions\InvalidArgumentException;
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
            throw new DomainException('The argument given does not contain multi bytes character.');
        }
    }

    public static function cast(object $target): self
    {
        if (!$target instanceof self) {
            throw new InvalidArgumentException('A not MultiBytesString argument is given.');
        }
        return $target;
    }

    public function equals(Type $other): bool
    {
        return $this->value === self::cast($other)->value();
    }
}
