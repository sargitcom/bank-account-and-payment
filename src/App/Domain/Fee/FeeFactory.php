<?php

namespace App\Domain\Fee;

class FeeFactory
{
    public static function getFeeByCode(string $code): AbstractFee
    {
        return match ($code) {
            DefaultFee::getName() => new DefaultFee()
        };
    }
}
