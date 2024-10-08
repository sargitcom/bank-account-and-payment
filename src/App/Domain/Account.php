<?php

namespace App\Domain;

use App\Domain\Currency\AbstractCurrency;
use App\Domain\Exception\TooManyWithdrawsException;
use Exception;

class Account
{
    public const MAX_WITHDRAW_NUMBER = 3;
    private array $paymentsCount = [];

    public function __construct(
        private readonly AbstractCurrency $currency,
        private readonly Balance $balance
    ) {
        $this->balance->rewind();
        while ($this->balance->valid()) {
            $this->incPaymentCount($this->balance->current());
            $this->balance->next();
        }
    }

    /**
     * @throws Exception
     */
    public function makePayment(Payment $payment): void
    {
        $this->assertCurrencyMatches($payment);
        if ($this->cantMakeDebitPayment($payment)) { $this->throwMaxPaymentMadeException(); }
        $this->incPaymentCount($payment);
        $this->balance->makeTransaction($payment);
    }

    private function cantMakeDebitPayment(Payment $payment): bool
    {
        return $this->isDebitPayment($payment) && $this->paymentWasMade($payment) && !$this->canWithdraw($payment);
    }

    /**
     * @throws Exception
     */
    private function throwMaxPaymentMadeException()
    {
        $maxWithdrawNumber = self::MAX_WITHDRAW_NUMBER;
        throw new TooManyWithdrawsException("Can`t withdraw deposit. Over number of withdraw: $maxWithdrawNumber");
    }

    private function isDebitPayment(Payment $payment): bool
    {
        return $payment->getPaymentType() === DebitPayment::PAYMENT_TYPE;
    }

    private function paymentWasMade(Payment $payment): bool
    {
        $paymentDate = $payment->getPaymentDate();
        return array_key_exists($paymentDate, $this->paymentsCount);
    }

    private function incPaymentCount(Payment $payment): void
    {
        $paymentDate = $payment->getPaymentDate();
         $this->paymentWasMade($payment) ?
            $this->paymentsCount[$paymentDate]++ :
            $this->paymentsCount[$paymentDate] = 0;
    }

    private function canWithdraw(Payment $payment): bool
    {
        return $this->paymentWasMade($payment) && $this->isNotMaxPaymentCount($payment);
    }

    private function isNotMaxPaymentCount(Payment $payment): bool
    {
        $paymentDate = $payment->getPaymentDate();
        return $this->paymentsCount[$paymentDate] < self::MAX_WITHDRAW_NUMBER;
    }

    public function getAmount(): float
    {
        return $this->balance->getAmount();
    }

    /**
     * @throws Exception
     */
    private function assertCurrencyMatches(Payment $payment): void
    {
        $accountCurrency = $this->currency->getCurrency();
        $paymentCurrency = $payment->getCurrency();
        if ($accountCurrency === $paymentCurrency) {
            return;
        }
        throw new Exception("Payment currency $paymentCurrency does not match account currency $accountCurrency");
    }
}
