<?php

namespace App\Application;

use App\Domain\Account;
use App\Domain\Amount;
use App\Domain\Currency\AbstractCurrency;
use App\Domain\CreditPayment;
use App\Domain\DebitPayment;
use DateTime;
use Exception;
use Throwable;

class PaymentService
{
    public function makeFirstPayments(AbstractCurrency $accountCurrency, Account $account): void
    {
        try {
            $payment1 = new CreditPayment($accountCurrency, Amount::create(100.01), new DateTime());
            $payment2 = new CreditPayment($accountCurrency, Amount::create(200.01), new DateTime());
            $payment3 = new CreditPayment($accountCurrency, Amount::create(300.01), new DateTime());

            $account->makePayment($payment1);
            $account->makePayment($payment2);
            $account->makePayment($payment3);

            $payment4 = new DebitPayment($accountCurrency, Amount::create(300), new DateTime());
            $payment5 = new DebitPayment($accountCurrency, Amount::create(200), new DateTime());
            $payment6 = new DebitPayment($accountCurrency, Amount::create(100.3), new DateTime());

            $account->makePayment($payment4);
            $account->makePayment($payment5);
            $account->makePayment($payment6);

            $payment7 = new DebitPayment($accountCurrency, Amount::create(100), new DateTime());
        } catch (Throwable $e) {
            echo $e->getMessage(); // not enough funds
        }
    }

    public function makeSecondPayments(AbstractCurrency $accountCurrency, Account $account): void
    {
        try {
            $payment1 = new CreditPayment($accountCurrency, Amount::create(100), new DateTime());

            $payment2 = new DebitPayment($accountCurrency, Amount::create(25), new DateTime());
            $payment3 = new DebitPayment($accountCurrency, Amount::create(25), new DateTime());
            $payment4 = new DebitPayment($accountCurrency, Amount::create(25), new DateTime());
            $payment5 = new DebitPayment($accountCurrency, Amount::create(25), new DateTime());

            $account->makePayment($payment1);
            $account->makePayment($payment2);
            $account->makePayment($payment3);
            $account->makePayment($payment4);
            $account->makePayment($payment5);
        } catch (Throwable $e) {
            echo $e->getMessage(); // can't make more that 3 debit payments
        }
    }

    public function makeThirdPayments(AbstractCurrency $accountCurrency, Account $account): void
    {
        try {
            $payment1 = new CreditPayment($accountCurrency, Amount::create(1000000.01), new DateTime());
            $payment2 = new CreditPayment($accountCurrency, Amount::create(2000000.01), new DateTime());
            $payment3 = new CreditPayment($accountCurrency, Amount::create(3000000.01), new DateTime());

            $account->makePayment($payment1);
            $account->makePayment($payment2);
            $account->makePayment($payment3);
        } catch (Throwable) {
            echo 'Retry payments. Account might be over budget';
        }
    }
}
