<?php

namespace Tests\Integration;

use App\Application\AccountService;
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
    /**
     * @throws Exception
     */
    public function testDeposit(): void
    {
        $accountCurrency = new PlnCurrency();
        $balance = new Balance($accountCurrency);
        $accountService = new AccountService($accountCurrency, $balance);

        $this->makeDeposit($accountCurrency, $accountService);
        $this->assertEquals(10000000.0, $accountService->getAccountAmount());
    }

    /**
     * @throws Exception
     */
    private function makeDeposit(AbstractCurrency $accountCurrency, AccountService $accountService): void
    {
        $accountService->makePayment(new CreditPayment($accountCurrency, Amount::create(10000000.0), new DateTime()));
    }
}
