<?php

namespace App\Http\Resources;

use App\Deliveries\AbstractDelivery;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryResource extends AbstractConvertableResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /**
         * @var AbstractDelivery $resource
         */
        $resource = $this->resource;

        return [
            'id'          => $resource->getId(),
            'title'       => $resource->getTitle(),
            'description' => $resource->getDescription(),
            'currency'    => $this->getCurrency(),
        ];
    }
}
