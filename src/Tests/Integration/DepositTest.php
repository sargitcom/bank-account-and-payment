<?php

namespace Tests\Integration;

use App\Domain\Account;
use App\Domain\Amount;
use App\Domain\Balance;
use App\Domain\CreditPayment;
use App\Domain\Currency\AbstractCurrency;
use App\Domain\Currency\PlnCurrency;
use DateTime;
use Exception;
use PHPUnit\Framework\TestCase;

class DepositTest extends TestCase
{
    private const AMOUNT = 10000000;

    /**
     * @throws Exception
     */
    public function testDeposit(): void
    {
        $accountCurrency = new PlnCurrency();
        $balance = new Balance($accountCurrency);
        $account = new Account($accountCurrency, $balance);
        $this->makeDeposit($accountCurrency, $account);
        $this->assertEquals(self::AMOUNT, $account->getAmount());
    }

    /**
     * @throws Exception
     */
    private function makeDeposit(AbstractCurrency $accountCurrency, Account $account): void
    {
        $account->makePayment(new CreditPayment($accountCurrency, Amount::create(self::AMOUNT), new DateTime()));
    }
}
