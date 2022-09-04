<?php
declare(strict_types=1);

namespace Graywings\Types\Units\Str;

use Graywings\Types\Str\AsciiString;
use Graywings\Types\Str\MultiBytesString;
use Graywings\Types\Str\Str;
use PHPUnit\Framework\TestCase;

class StrTest extends TestCase
{
    /**
     * @return void
     */
    public function test_newAsciiString(): void
    {
        $str = Str::new('Hello');
        self::assertTrue($str instanceof AsciiString);
        self::assertSame('Hello', $str->value());
        self::assertSame('Hello', $str->__toString());
    }

    /**
     * @return void
     */
    public function test_newMultiByteString(): void
    {
        $str = Str::new('こんばんは');
        self::assertTrue($str instanceof MultiBytesString);
        self::assertSame('こんばんは', $str->value());
        self::assertSame('こんばんは', $str->__toString());
    }

    /**
     * @return void
     */
    public function test_newNoArgument(): void
    {
        $str = Str::new();
        self::assertTrue($str instanceof AsciiString);
        self::assertSame('', $str->value());
        self::assertSame('', $str->__toString());
    }
}
