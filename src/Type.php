<?php
declare(strict_types=1);

namespace Graywings\Types;

interface Type
{
    public function value(): mixed;

    public static function cast(object $target): self;

    public function equals(object $other): bool;

    public function __toString(): string;

    public function __clone(): void;
}
