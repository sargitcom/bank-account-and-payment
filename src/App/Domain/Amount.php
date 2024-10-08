<?php

namespace App\Domain;

use Exception;

class Amount
{
    private float $amount;

    /**
     * @throws Exception
     */
    private function __construct(float $amount)
    {
        $this->assertNotEqualZero($amount);
        $this->setAmount($amount);
    }

    /** @throws Exception */
    public static function create(float $amount): self
    {
        return new self($amount);
    }

    /** @throws Exception */
    private function assertNotEqualZero(float $amount): void
    {
        if ($amount > 0 || $amount < 0) {
            return;
        }

        throw new Exception("Amount equal to zero");
    }

    private function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
}
