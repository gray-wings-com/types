<?php
declare(strict_types=1);

namespace Graywings\Types\Units\Str;

use Graywings\Exceptions\LogicExceptions\DomainException;
use Graywings\Exceptions\LogicExceptions\InvalidArgumentException;
use Graywings\Types\Str\AsciiString;
use Graywings\Types\Type;
use PHPUnit\Framework\TestCase;

class AsciiStringTest extends TestCase
{
    /**
     * @return string[][]
     */
    public static function stringValue(): array
    {
        return [
            ['Hello'],
            ['World'],
            ['Right side'],
            [<<< EOF
SELECT
  *
FROM
  users;
EOF
]
        ];
    }

    /**
     * @param string $stringValue
     * @return void
     * @dataProvider stringValue
     */
    public function test_construct(string $stringValue): void
    {
        $str = new AsciiString($stringValue);
        self::assertSame($stringValue, $str->value());
    }

    /**
     * @return string[][]
     */
    public static function invalidString(): array
    {
        return [
            ['こんにちは'],
            ['World）']
        ];
    }

    /**
     * @param string $invalidStr
     * @return void
     * @dataProvider invalidString
     */
    public function test_constructInvalid(string $invalidStr): void
    {
        self::expectException(DomainException::class);
        self::expectExceptionMessage('The argument given is not only ascii character.');
        new AsciiString($invalidStr);
    }

    public function test_cast(): void
    {
        $str = new AsciiString();
        AsciiString::cast($str);
        self::assertSame('', $str->value());
    }

    public function test_castInvalid(): void
    {
        $sample = new Sample();
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('A not AsciiString argument is given.');
        AsciiString::cast($sample);
    }

    public function test_equals(): void
    {
        $str1 = new AsciiString('Hello');
        $str2 = new AsciiString('World');
        $str3 = new AsciiString('Hello');

        self::assertEquals($str1, $str3);
        self::assertNotEquals($str1, $str2);
        self::assertNotEquals($str2, $str3);

        self::assertFalse($str1->equals($str2));
        self::assertTrue($str1->equals($str3));

        self::assertFalse($str2->equals($str1));
        self::assertFalse($str2->equals($str3));

        self::assertTrue($str3->equals($str1));
        self::assertFalse($str3->equals($str2));
    }

    public function test_clone(): void
    {
        $str = new AsciiString();
        $copied = $str;
        $cloned = clone $str;

        self::assertSame($copied, $str);
        self::assertEquals($copied, $str);

        self::assertNotSame($cloned, $str);
        self::assertEquals($cloned, $str);

        self::assertSame('', $str->value());
        self::assertSame('', $cloned->value());
        self::assertSame('', $copied->value());
    }
}

class Sample implements Type {
    public function value(): mixed
    {
        return '';
    }

    public static function cast(object $target): Type
    {
        return new AsciiString();
    }

    public function equals(Type $other): bool
    {
        return true;
    }

    public function __toString(): string
    {
        return '';
    }
}
