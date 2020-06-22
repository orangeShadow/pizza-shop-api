<?php
declare(strict_types=1);

namespace App\Deliveries;

use App\Services\PriceFormatter;
use Illuminate\Support\Str;

/**
 * Class Courrier
 * @package App\Deliveries
 */
class Courrier extends AbstractDelivery
{
    /**
     * @var int
     */
    protected $id = 2;

    /**
     * @var bool
     */
    protected $isActive = true;

    /**
     * @var string
     */
    protected $title = "Courrier";

    /**
     * @var string
     */
    protected $description = "Courrier price is %s, but if your basket price more then %s, then it is free!";

    /**
     * @var string
     */
    protected $currency = "EUR";

    /**
     * Price in cents
     * @var int
     */
    protected $price = 500;

    /**
     * Amount when price is free in cents;
     * @var int
     */
    protected $freePriceBorder = 10000;

    public function getDescription(): string
    {
        $currency = config('app.currency');
        $message = sprintf($this->description,
            $this->priceFormatter->handler(
                $this->priceConverting->handler($this->price, $this->currency, $currency), $currency),
            $this->priceFormatter->handler(
                $this->priceConverting->handler($this->freePriceBorder, $this->currency, $currency), $currency)
            );

        return $message;
    }

    /**
     * @param int $basketPrice
     * @param string $basketCurrency
     * @return int
     */
    public function priceCalculate(int $basketPrice, string $basketCurrency): int
    {

        if ($basketCurrency !== $this->currency) {
            $basketPrice = $this->priceConverting->handler($basketPrice, $basketCurrency, $this->currency);
        }

        //
        if ($basketPrice >= $this->freePriceBorder) {
            return 0;
        }

        return $this->priceConverting->handler($this->price, $this->currency, $basketCurrency);
    }
}
