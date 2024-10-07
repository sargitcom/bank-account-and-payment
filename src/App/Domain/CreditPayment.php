<?php

namespace App\Domain;

use App\Domain\Currency\AbstractCurrency;
use DateTime;
use InvalidArgumentException;

class CreditPayment extends Payment
{
    public function __construct(
        AbstractCurrency $currency,
        Amount           $amount,
        DateTime         $paymentDate
    ) {
        $this->assertIsPositiveAmount($amount->getAmount());
        parent::__construct($currency, $amount, $paymentDate);
    }

    private function assertIsPositiveAmount(float $amount): void
    {
        if ($amount > 0) {
            return;
        }

        throw new InvalidArgumentException("Credit amount $amount is not greater than zero");
    }
}
