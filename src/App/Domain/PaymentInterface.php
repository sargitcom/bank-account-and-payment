<?php

namespace App\Domain;

interface PaymentInterface
{
    public function getCurrency(): string;
    public function getAmount(): float;
    public function getPaymentDate(): string;
    public function getPaymentType(): string;
}
