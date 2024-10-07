<?php

namespace App\Domain\Currency;

class CurrencyFactory
{
    public static function getCurrencyByCode(string $currencyCode): AbstractCurrency
    {
        return match($currencyCode) {
            PlnCurrency::getCurrency() => new PlnCurrency()
        };
    }
}
