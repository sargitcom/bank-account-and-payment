<?php

namespace App\Application;

use App\Domain\Account;
use App\Domain\Balance;
use App\Domain\Currency\AbstractCurrency;
use App\Domain\Payment;
use Exception;

class AccountService
{
    private Account $account;

    public function __construct(AbstractCurrency $currency, Balance $balance)
    {
        $this->account = new Account($currency, $balance);
    }

    /**
     * @throws Exception
     */
    public function makePayment(Payment $payment): void
    {
        $this->account->makePayment($payment);
    }

    public function getAccountAmount(): float
    {
        return $this->account->getAmount();
    }
}
