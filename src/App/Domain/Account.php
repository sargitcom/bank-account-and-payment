<?php

namespace App\Domain;

use App\Domain\Currency\AbstractCurrency;
use Exception;

class Account
{
    public function __construct(private readonly AbstractCurrency $currency, private readonly Balance $balance) {}

    /**
     * @throws Exception
     */
    public function makePayment(Payment $payment): void
    {
        $this->assertCurrencyMatches($payment->getCurrency());
        $this->balance->addTransaction($payment);
    }

    public function getAmount(): string
    {
        return $this->balance->getAmount();
    }

    /**
     * @throws Exception
     */
    private function assertCurrencyMatches(string $currency): void
    {
        $paymentCurrency = $this->currency->getCurrency();
        if ($currency === $paymentCurrency) {
            return;
        }
        throw new Exception("Payment currency $paymentCurrency does not match account currency $currency");
    }
}
