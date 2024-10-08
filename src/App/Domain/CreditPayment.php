<?php

namespace App\Domain;

use App\Domain\Currency\AbstractCurrency;
use DateTime;
use InvalidArgumentException;

class CreditPayment extends Payment
{
    public const PAYMENT_TYPE = 'CREDIT';

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

        throw new InvalidArgumentException("Credit amount $amount is less than zero");
    }

    public function getPaymentType(): string
    {
        return self::PAYMENT_TYPE;
    }
}
