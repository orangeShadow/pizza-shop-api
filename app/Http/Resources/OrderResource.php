<?php

namespace App\Http\Resources;

use App\Models\Order;
use App\Services\PriceFormatter;

/**
 * Class ProductResource
 * @package App\Http\Resources
 */
class OrderResource extends AbstractConvertableResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /**
         * @var Order $resource
         */
        $resource = $this->resource;

        $priceFormatter = new PriceFormatter();

        $basket = BasketResource::collection($resource->basket);

        $data = [
            'id'         => $resource->getId(),
            'basket'     => $basket,
            'totalPrice' => $priceFormatter->handler(
                $this->calculatePrice($resource->getTotalPrice(), $resource->getCurrency()),
                $resource->getCurrency()
            ),
            'currency'   => $this->getCurrency(),
            'created_at' => $resource->getCreatedAt(),
            'name'       => $resource->getName(),
            'email'      => $resource->getEmail(),
        ];

        if (!empty($resource->getAddress())) {

            if ($resource->getDeliveryPrice() === 0) {
                $data['deliveryPrice'] = 'Free';
            } else {
                $data['deliveryPrice'] = $priceFormatter->handler($resource->getDeliveryPrice(), $resource->getCurrency());
            }
            $data['address'] = $resource->getAddress();
        }

        return $data;
    }

}
