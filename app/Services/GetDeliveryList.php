<?php
declare(strict_types=1);

namespace App\Services;

use App\Deliveries\AbstractDelivery;
use App\Enums\DeliveryEnum;
use Illuminate\Support\Collection;

class GetDeliveryList
{
    protected $priceConverting;

    public function __construct()
    {
        $this->priceConverting = new PriceConverting();
    }

    /**
     * @return Collection
     */
    public function handler(): Collection
    {
        $namespace = "App\Deliveries\\";
        $deliveries = new Collection();
        foreach (DeliveryEnum::getKeys() as $className) {
            try {
                $fullClassName = $namespace . $className;

                /**
                 * @var AbstractDelivery $delivery
                 */
                $delivery = new $fullClassName();

                if (!$delivery->getActive()) {
                    continue;
                }

                $deliveries->add($delivery);

            } catch (\Exception $e) {
                \Log::error(__CLASS__, [$e]);
            }
        }

        return $deliveries;
    }
}
