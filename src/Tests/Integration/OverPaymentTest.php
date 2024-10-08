<?php

namespace Tests\Integration;

use App\Domain\Account;
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
        $accountCurrency = new PlnCurrency();
        $balance = new Balance($accountCurrency);
        $account = new Account($accountCurrency, $balance);

        $payment1 = new CreditPayment($accountCurrency, Amount::create(PHP_FLOAT_MAX), new DateTime());
        $payment2 = new CreditPayment($accountCurrency, Amount::create(100), new DateTime());

        $account->makePayment($payment1);
        $account->makePayment($payment2);

        $this->expectException(Exception::class);
    }
}
