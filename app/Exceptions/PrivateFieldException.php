<?php
declare(strict_types=1);


namespace App\Exceptions;


use Throwable;

class PrivateFieldException extends AbstractPizzaException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
