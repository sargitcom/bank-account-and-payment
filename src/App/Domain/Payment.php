<?php

namespace App\Domain;

use App\Domain\Currency\AbstractCurrency;
use DateTime;

abstract class Payment implements PaymentInterface
{
    public function __construct(
        protected AbstractCurrency  $currency,
        protected Amount            $amount,
        protected DateTime          $paymentDate
    ) {}

    public function getCurrency(): string
    {
        return $this->currency->getCurrency();
    }

    public function getAmount(): float
    {
        return $this->amount->getAmount();
    }

    public function getPaymentDate(): string
    {
        return $this->paymentDate->format('Y-m-d');
    }
}
