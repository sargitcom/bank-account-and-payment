<?php

namespace Tests;

use App\Domain\Amount;
use Exception;
use PHPUnit\Framework\TestCase;

final class AmountTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testCreate(): void
    {
        $amount = Amount::create(100);
        $this->assertEquals(100, $amount->getAmount());
    }

    public function testAmountZero(): void
    {
        $this->expectException(Exception::class);
        Amount::create(0);
    }
}
