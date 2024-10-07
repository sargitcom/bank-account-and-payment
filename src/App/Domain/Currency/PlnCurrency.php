<?php

namespace App\Domain\Currency;

class PlnCurrency extends AbstractCurrency
{
    public static function getCurrency(): string
    {
        return 'PLN';
    }
}
