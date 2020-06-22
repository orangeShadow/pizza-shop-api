<?php
declare(strict_types=1);


namespace App\Services;


use Carbon\Carbon;
use AshAllenDesign\LaravelExchangeRates\Classes\ExchangeRate;

class PriceConverting
{
    /**
     * @var ExchangeRate
     */
    protected $exchangeRates;

    public function __construct()
    {
        $this->exchangeRates = new ExchangeRate();
    }


    /**
     * Convert Currency from currency to needed
     * if to is empty get site currency
     *
     * @param int $price
     * @param string $fromCurrency
     * @param string $toCurrency
     *
     * @return int
     */
    public function handler(int $price, string $fromCurrency, string $toCurrency): int
    {

        if ($fromCurrency === $toCurrency) {
            return $price;
        }

        return (int)$this->exchangeRates->convert($price, $fromCurrency, $toCurrency,Carbon::today(),0);
    }
}
