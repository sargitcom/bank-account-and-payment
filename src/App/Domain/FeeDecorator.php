<?php

namespace App\Domain;

use App\Domain\Fee\AbstractFee;
use App\Domain\Fee\DefaultFee;

class FeeDecorator extends Payment
{
    private AbstractFee $fee;

    public function __construct(private readonly Payment $payment)
    {
        $this->fee = new DefaultFee();

        parent::__construct(
            $payment->getCurrency(),
            Amount::create($this->payment->getAmount()),
            $this->payment->getPaymentDate());
    }

    public function getAmount(): float
    {
        return $this->payment->getAmount() + $this->fee->getFee($this->payment->getAmount());
    }
}
