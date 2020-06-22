<?php
declare(strict_types=1);


namespace App\Services;

use App\Enums\CurrencyEnum;

/**
 * Class PriceFormatter
 * @package App\Services
 */
class PriceFormatter
{
    /**
     * @param int $price
     * @param string $currency
     * @return string
     */
    public function handler(int $price, string $currency): string
    {
        return implode(' ',[number_format($price / 100, 2) ,CurrencyEnum::USD === $currency ? "$" : "€"]);
    }
}
