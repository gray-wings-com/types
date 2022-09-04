<?php
declare(strict_types=1);

namespace Graywings\Types\Units\Str;

use Graywings\Exceptions\LogicExceptions\DomainException;
use Graywings\Exceptions\LogicExceptions\InvalidArgumentException;
use Graywings\Types\Str\MultiBytesString;
use PHPUnit\Framework\TestCase;

class MultiBytesStringTest extends TestCase
{
    /**
     * @return string[][]
     */
    public static function stringValue(): array
    {
        return [
            ['こんにちは'],
            ['世界'],
            ['新明解国語辞典'],
            [<<< EOF
吾輩は猫である。
名前はまだない。
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
        $str = new MultiBytesString($stringValue);
        self::assertSame($stringValue, $str->value());
    }

    /**
     * @return string[][]
     */
    public static function invalidString(): array
    {
        return [
            ['Hello'],
            ['World']
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
        self::expectExceptionMessage('The argument given does not contain multi bytes character.');
        new MultiBytesString($invalidStr);
    }

    /**
     * @return void
     */
    public function test_cast(): void
    {
        $str = new MultiBytesString('');
        MultiBytesString::cast($str);
        self::assertSame('', $str->value());
    }

    public function test_castInvalid(): void
    {
        $sample = new Sample();
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('A not MultiBytesString argument is given.');
        MultiBytesString::cast($sample);
    }

    public function test_equals(): void
    {
        $str1 = new MultiBytesString('こんにちは');
        $str2 = new MultiBytesString('世界');
        $str3 = new MultiBytesString('こんにちは');

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
        $str = new MultiBytesString('');
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
