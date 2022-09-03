<?php
declare(strict_types=1);

namespace Graywings\Types\Units\Byte;

use Graywings\Exceptions\LogicExceptions\DomainException;
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

    public static function byteIntegers(): array
    {
        return [
            [0],
            [128],
            [255]
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
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage($invalidByteInteger . ' is not byte value.');
        new Byte($invalidByteInteger);
    }
}
