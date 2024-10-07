<?php

namespace App\Domain\Currency;

abstract class AbstractCurrency
{
    abstract public static function getCurrency(): string;
}
