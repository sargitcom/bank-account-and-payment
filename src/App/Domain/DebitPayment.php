<?php

namespace App\Domain;

use App\Domain\Currency\AbstractCurrency;
use DateTime;
use InvalidArgumentException;

class DebitPayment extends Payment
{
    public function __construct(
        AbstractCurrency $currency,
        Amount           $amount,
        DateTime         $paymentDate
    ) {
        $this->assertIsNegativeAmount($amount->getAmount());
        parent::__construct($currency, $amount, $paymentDate);
    }

    private function assertIsNegativeAmount(float $amount): void
    {
        if ($amount < 0) {
            return;
        }

        throw new InvalidArgumentException("Credit amount $amount is greater than zero");
    }
}
