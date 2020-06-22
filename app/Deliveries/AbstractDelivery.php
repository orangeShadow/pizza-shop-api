<?php
declare(strict_types=1);


namespace App\Deliveries;


use App\Contacts\PriceConvertible;
use App\Services\PriceConverting;
use App\Services\PriceFormatter;

/**
 * Class AbstractDelivery
 * @package App\Services\Deliveries
 */
abstract class AbstractDelivery
{

    /**
     * @var
     */
    protected $priceConverting;

    /**
     * @var
     */
    protected $priceFormatter;

    /**
     * Courrier constructor.
     */
    public function __construct()
    {
        $this->priceConverting = new PriceConverting();
        $this->priceFormatter = new PriceFormatter();

    }

    /**
     * @var int
     */
    protected $id;

    /**
     * @var bool
     */
    protected $isActive;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $currency;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function getActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param int $basketPrice
     * @param string $basketCurrency
     * @return int
     */
    public abstract function priceCalculate(int $basketPrice, string $basketCurrency): int;
}
