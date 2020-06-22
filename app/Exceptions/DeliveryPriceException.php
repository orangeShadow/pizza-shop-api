<?php
declare(strict_types=1);


namespace App\Exceptions;


use Throwable;

class DeliveryPriceException extends AbstractPizzaException
{
    public function __construct($message = "Delivery price is different.", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
