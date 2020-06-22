<?php
declare(strict_types=1);


namespace App\Contacts;

/**
 * Interface for Price Convertible
 * @package App\Contacts
 */
interface PriceConvertible
{
    /**
     * Get Price
     * @return int
     */
    public function getPrice(): int;

    /**
     * Get currency
     * @return mixed
     */
    public function getCurrency(): string;
}
