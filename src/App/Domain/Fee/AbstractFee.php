<?php

namespace App\Domain\Fee;

abstract class AbstractFee
{
    abstract public function getFee(float $amount): float;
    abstract public static function getName(): string;
}
