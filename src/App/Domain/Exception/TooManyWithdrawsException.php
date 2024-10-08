<?php

namespace App\Domain\Exception;

use Exception;
use Throwable;

class TooManyWithdrawsException extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        if ($message !== "") {
            $message .= " - ";
        }

        $message .= "Too many withdraws exception";

        parent::__construct($message, $code, $previous);
    }
}