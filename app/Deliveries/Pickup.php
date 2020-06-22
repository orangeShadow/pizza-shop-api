<?php
declare(strict_types=1);


namespace App\Deliveries;

class Pickup extends AbstractDelivery
{
    /**
     * @var int
     */
    protected $id = 1;

    /**
     * @var string
     */
    protected $currency = "USD";

    /**
     * @var string
     */
    protected $title = "Pickup";

    /**
     * @var string
     */
    protected $description = "Pickup from the store is free";

    /**
     * @var bool
     */
    protected $isActive = true;

    public function priceCalculate(int $basketPrice, string $basketCurrency): int
    {
        return 0;
    }
}
