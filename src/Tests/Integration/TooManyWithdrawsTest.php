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

class TooManyWithdrawsTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testWithdraw(): void
    {
        $accountCurrency = new PlnCurrency();
        $balance = new Balance($accountCurrency);
        $account = new Account($accountCurrency, $balance);

        $this->makeDeposit($accountCurrency, $account);
        $this->makeWithdraw($accountCurrency, $account);
        $this->expectException(Exception::class);
    }

    /**
     * @throws Exception
     */
    private function makeDeposit(AbstractCurrency $accountCurrency, Account $account): void
    {
        $account->makePayment(new CreditPayment($accountCurrency, Amount::create(100), new DateTime()));
    }

    /**
     * @throws Exception
     */
    private function makeWithdraw(AbstractCurrency $accountCurrency, Account $account): void
    {
        for ($i = 0; $i < 4; $i++) {
            $account->makePayment(new DebitPayment($accountCurrency, Amount::create(25), new DateTime()));
        }
    }
}
