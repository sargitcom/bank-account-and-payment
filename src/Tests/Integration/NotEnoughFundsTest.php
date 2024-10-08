<?php

namespace Tests\Integration;

use App\Domain\Account;
use App\Domain\Amount;
use App\Domain\Balance;
use App\Domain\CreditPayment;
use App\Domain\Currency\AbstractCurrency;
use App\Domain\Currency\PlnCurrency;
use App\Domain\DebitPayment;
use DateTime;
use Exception;
use PHPUnit\Framework\TestCase;

class NotEnoughFundsTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testNotEnoughFunds(): void
    {
        $accountCurrency = new PlnCurrency();
        $balance = new Balance($accountCurrency);
        $account = new Account($accountCurrency, $balance);
        $this->makeDeposit($accountCurrency, $account);
        $this->tryToWithdraw($accountCurrency, $account);
        $this->expectException(Exception::class);
    }

    /**
     * @throws Exception
     */
    private function makeDeposit(AbstractCurrency $accountCurrency, Account $account): void
    {
        $account->makePayment(new CreditPayment($accountCurrency, Amount::create(10000), new DateTime()));
    }

    /**
     * @throws Exception
     */
    private function tryToWithdraw(AbstractCurrency $accountCurrency, Account $account): void
    {
        $account->makePayment(new DebitPayment($accountCurrency, Amount::create(20000), new DateTime()));
    }
}
