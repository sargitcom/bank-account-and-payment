<?php

namespace App\Domain\Fee;

class DefaultFee extends AbstractFee
{
    public const FEE_NAME = "HALF_PERCENT";
    private const FEE_AMOUNT = 0.5 / 100;

    public static function getName(): string
    {
        return self::FEE_NAME;
    }

    public function getFee(float $amount): float
    {
        return self::FEE_AMOUNT * $amount;
    }
}
