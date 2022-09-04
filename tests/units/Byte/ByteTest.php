<?php
declare(strict_types=1);

namespace Graywings\Types\Units\Byte;

use Graywings\Exceptions\LogicExceptions\DomainException;
use Graywings\Exceptions\LogicExceptions\InvalidArgumentException;
use Graywings\Types\Byte\Byte;
use PHPUnit\Framework\TestCase;

class ByteTest extends TestCase
{
    /**
     * @return void
     */
    public function test_constructNoArgument(): void
    {
        $byte = new Byte();
        self::assertSame(0x00, $byte->value());
    }

    /**
     * @return array<int, array{int, string}>
     */
    public static function byteIntegers(): array
    {
        return [
            [0, '0x00'],
            [1, '0x01'],
            [128, '0x80'],
            [255, '0xff']
        ];
    }

    /**
     * @param int $byteInteger
     * @return void
     * @dataProvider byteIntegers
     */
    public function test_construct(
        int $byteInteger
    ): void
    {
        $byte = new Byte($byteInteger);
        self::assertSame($byteInteger, $byte->value());
    }

    /**
     * @return int[][]
     */
    public static function invalidByteIntegers(): array
    {
        return [
            [-10000],
            [-1],
            [256],
            [1000]
        ];
    }

    /**
     * @param int $invalidByteInteger
     * @return void
     * @dataProvider invalidByteIntegers
     */
    public function test_invalidConstruct(
        int $invalidByteInteger
    ): void
    {
        self::expectException(DomainException::class);
        self::expectExceptionMessage($invalidByteInteger . ' is not byte value.');
        new Byte($invalidByteInteger);
    }

    public function test_cast(): void
    {
        $byte = new Byte();
        $castedByte = Byte::cast($byte);
        self::assertSame(0x00, $castedByte->value());
    }

    public function test_castInvalid(): void
    {
        $sample = new Sample();
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('A not Byte argument was given.');
        Byte::cast($sample);
    }

    /**
     * @return void
     */
    public function test_equals(): void
    {
        $byte1 = new Byte(0x00);
        $byte2 = new Byte(0xff);
        $byte3 = new Byte(0x00);
        self::assertEquals($byte1, $byte3);
        self::assertNotEquals($byte1, $byte2);
        self::assertNotEquals($byte2, $byte3);

        self::assertFalse($byte1->equals($byte2));
        self::assertTrue($byte1->equals($byte3));

        self::assertFalse($byte2->equals($byte1));
        self::assertFalse($byte2->equals($byte3));

        self::assertTrue($byte3->equals($byte1));
        self::assertFalse($byte3->equals($byte2));
    }

    /**
     * @param int $byte
     * @param string $byteString
     * @return void
     * @dataProvider byteIntegers
     */
    public function test_toString(
        int $byte,
        string $byteString
    ): void
    {
        $byte = new Byte($byte);
        self::assertSame($byteString, $byte->__toString());
    }

    public function test_clone(): void
    {
        $byte = new Byte();
        $copied = $byte;
        $cloned = clone $byte;

        self::assertSame($copied, $byte);
        self::assertEquals($copied, $byte);

        self::assertNotSame($cloned, $byte);
        self::assertEquals($cloned, $byte);

        self::assertSame(0x00, $byte->value());
        self::assertSame(0x00, $cloned->value());
        self::assertSame(0x00, $copied->value());
    }
}

class Sample {}
