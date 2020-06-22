<?php
declare(strict_types=1);


namespace App\Http\Resources;

use App\Services\PriceConverting;
use Illuminate\Http\Resources\Json\JsonResource;


abstract class AbstractConvertableResource extends JsonResource
{
    /**
     * @var PriceConverting
     */
    protected $priceConverting;

    /**
     * AbstractConvertableResource constructor.
     * @param $resource
     */
    public function __construct($resource)
    {
        parent::__construct($resource);
        $this->priceConverting = new PriceConverting();
    }

    /**
     * Calculate price to needed currency
     *
     * @param int $price
     * @param string $currentElementCurrency
     *
     * @return int
     */
    protected function calculatePrice(int $price, string $currentElementCurrency): int
    {
        return $this->priceConverting->handler($price, $currentElementCurrency, $this->getCurrency());
    }

    /**
     * Return site currency
     */
    protected function getCurrency(): string
    {
        return config('app.currency');
    }
}
