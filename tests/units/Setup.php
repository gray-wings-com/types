<?php
declare(strict_types=1);

namespace Graywings\Types\Units;

use PHPUnit\Framework\TestCase;

class Setup extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        initErrorhandler();
    }
}
