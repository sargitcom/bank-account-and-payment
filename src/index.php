<?php

require_once 'vendor/autoload.php';

$accountCurrency = new App\Domain\Currency\PlnCurrency();

$paymentService = new \Tests\Integration\PaymentService();

# first payment
$accountBalance = new App\Domain\Balance($accountCurrency);
$account = new App\Domain\Account($accountCurrency, $accountBalance);
echo "Current account balance: " . $account->getAmount();
$paymentService->makeFirstPayments($accountCurrency, $account);

# second payment
$accountBalance = new App\Domain\Balance($accountCurrency);
$account = new App\Domain\Account($accountCurrency, $accountBalance);
echo "Current account balance: " . $account->getAmount();
$paymentService->makeSecondPayments($accountCurrency, $account);

# third payment
$accountBalance = new App\Domain\Balance($accountCurrency);
$account = new App\Domain\Account($accountCurrency, $accountBalance);
echo "Current account balance: " . $account->getAmount();
$paymentService->makeThirdPayments($accountCurrency, $account);
