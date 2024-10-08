<?php

namespace App\Domain;

use App\Domain\Currency\CurrencyFactory;
use App\Domain\Fee\AbstractFee;
use App\Domain\Fee\DefaultFee;
use DateTime;
use Exception;

class FeeDecorator extends Payment
{
    private AbstractFee $fee;

    /**
     * @throws Exception
     */
    public function __construct(private readonly Payment $payment)
    {
        $this->fee = new DefaultFee();

        parent::__construct(
            CurrencyFactory::getCurrencyByCode($payment->getCurrency()),
            Amount::create($this->payment->getAmount()),
            new DateTime($this->payment->getPaymentDate()));
    }

    public function getAmount(): float
    {
        return $this->payment->getAmount() - $this->fee->getFee($this->payment->getAmount());
    }

    public function getPaymentType(): string
    {
        return $this->payment->getPaymentType();
    }
}
