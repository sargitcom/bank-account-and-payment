<?php

namespace Tests\Integration;

use App\Application\AccountService;
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
        $this->expectException(Exception::class);

        $accountCurrency = new PlnCurrency();
        $balance = new Balance($accountCurrency);
        $accountService = new AccountService($accountCurrency, $balance);

        $this->makeDeposit($accountCurrency, $accountService);
        $this->tryToWithdraw($accountCurrency, $accountService);
    }

    /**
     * @throws Exception
     */
    private function makeDeposit(AbstractCurrency $accountCurrency, AccountService $accountService): void
    {
        $accountService->makePayment(new CreditPayment($accountCurrency, Amount::create(10000.0), new DateTime()));
    }

    /**
     * @throws Exception
     */
    private function tryToWithdraw(AbstractCurrency $accountCurrency, AccountService $accountService): void
    {
        $accountService->makePayment(new DebitPayment($accountCurrency, Amount::create(-20000.0), new DateTime()));
    }
}
