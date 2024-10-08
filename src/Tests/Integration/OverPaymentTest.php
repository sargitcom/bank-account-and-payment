<?php

namespace Tests\Integration;

use App\Application\AccountService;
use App\Domain\Amount;
use App\Domain\Balance;
use App\Domain\CreditPayment;
use App\Domain\Currency\PlnCurrency;
use DateTime;
use Exception;
use PHPUnit\Framework\TestCase;

class OverPaymentTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testOverPayment(): void
    {
        $this->expectException(Exception::class);

        $accountCurrency = new PlnCurrency();
        $balance = new Balance($accountCurrency);
        $accountService = new AccountService($accountCurrency, $balance);
        $payment1 = new CreditPayment($accountCurrency, Amount::create(PHP_FLOAT_MAX), new DateTime());
        $payment2 = new CreditPayment($accountCurrency, Amount::create(1000), new DateTime());

        $accountService->makePayment($payment1);
        $accountService->makePayment($payment2);
    }
}
