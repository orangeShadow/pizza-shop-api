<?php
declare(strict_types=1);


namespace App\Exceptions;


use Throwable;

class CurrencyDifferenceException extends AbstractPizzaException
{
    public function __construct($message = "Basket item currency and order currency is different.", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
