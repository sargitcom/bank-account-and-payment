<?php

namespace App\Domain;

use App\Domain\Currency\AbstractCurrency;
use Exception;
use Iterator;

class Balance implements Iterator
{
    private int $index = 0;

    /**
     * @var Payment[] $data
     */
    private array $data = [];

    private float $balanceAmount = 0;

    public function __construct(private readonly AbstractCurrency $currency) {}

    public function getAmount(): float
    {
        return $this->balanceAmount;
    }

    /** @throws Exception */
    public function addTransaction(Payment $payment): void
    {
        /*
        $this->assertCurrencyMatch($payment->getCurrency());
        if ($this->isDebitPayment($payment)) {
            $payment = new FeeDecorator($payment);

            if (!$this->isEnoughAmount($payment)) {
                throw new Exception("Insufficient balance amount");
            }

            $this->appendTransaction($payment);
            $this->setBalance($payment);
            return;
        }

        if (!$this->canDepositAmount($payment)) {
            throw new Exception("Can`t deposit this amount of monet. Amount overflow");
        }

        $this->appendTransaction($payment);
        $this->setBalance($payment);
        */
    }

    private function appendTransaction(Payment $payment): void
    {
        $this->data[] = $payment;
    }

    private function setBalance(Payment $payment): void
    {
        $this->balanceAmount += $payment->getAmount();
    }

    /** @throws Exception */
    private function assertCurrencyMatch(string $paymentCurrency): void
    {
        $balanceCurrency = $this->currency->getCurrency();
        if ($balanceCurrency === $paymentCurrency) {
            return;
        }

        throw new Exception("Balance currency $balanceCurrency does not match payment currency $paymentCurrency");
    }

    private function isDebitPayment(Payment $payment): bool
    {
        return is_a($payment, DebitPayment::class);
    }

    private function isEnoughAmount(Payment $payment): bool
    {
        return $this->balanceAmount >= $payment->getAmount();
    }

    private function canDepositAmount(Payment $payment): bool
    {
        return $this->balanceAmount <= PHP_FLOAT_MAX - $payment->getAmount();
    }

    public function current(): Payment
    {
        return $this->data[$this->index];
    }

    public function next(): void
    {
        $this->index++;
    }

    public function key(): int
    {
        return $this->index;
    }

    public function valid(): bool
    {
        return array_key_exists($this->index, $this->data);
    }

    public function rewind(): void
    {
        $this->index = 0;
    }
}
