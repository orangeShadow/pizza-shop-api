<?php
declare(strict_types=1);


namespace App\Exceptions;


use Throwable;

class PriceDiffernceException extends AbstractPizzaException
{
    public function __construct($message = "Price in basket and in database is different", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
