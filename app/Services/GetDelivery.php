<?php
declare(strict_types=1);


namespace App\Services;

use App\Deliveries\AbstractDelivery;
use App\Enums\DeliveryEnum;
use App\Exceptions\DeliveryNotFoundException;

class GetDelivery
{
    /**
     * @param int $deliveryId
     * @return AbstractDelivery
     * @throws DeliveryNotFoundException
     */
    public function handler(int $deliveryId): AbstractDelivery
    {
        try {
            $className = '\App\Deliveries\\' . DeliveryEnum::getKey($deliveryId);
            /**
             * @var AbstractDelivery $delivery
             */

            $delivery = new $className();

            return $delivery;
        } catch (\Exception $exception) {
            throw new DeliveryNotFoundException();
        }
    }
}
