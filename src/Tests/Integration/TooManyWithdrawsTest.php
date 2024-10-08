<?php

namespace Tests\Integration;

use App\Application\AccountService;
use App\Domain\Amount;
use App\Domain\Balance;
use App\Domain\CreditPayment;
use App\Domain\Currency\AbstractCurrency;
use App\Domain\Currency\PlnCurrency;
use App\Domain\DebitPayment;
use App\Domain\Exception\TooManyWithdrawsException;
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
        $this->expectException(TooManyWithdrawsException::class);

        $accountCurrency = new PlnCurrency();
        $balance = new Balance($accountCurrency);
        $accountService = new AccountService($accountCurrency, $balance);

        $this->makeDeposit($accountCurrency, $accountService);
        $this->makeWithdraw($accountCurrency, $accountService);
    }

    /**
     * @throws Exception
     */
    private function makeDeposit(AbstractCurrency $accountCurrency, AccountService $accountService): void
    {
        $accountService->makePayment(new CreditPayment($accountCurrency, Amount::create(100), new DateTime()));
    }

    /**
     * @throws Exception
     */
    private function makeWithdraw(AbstractCurrency $accountCurrency, AccountService $accountService): void
    {
        for ($i = 0; $i < 4; $i++) {
            $accountService->makePayment(new DebitPayment($accountCurrency, Amount::create(-25), new DateTime()));
        }
    }
}
