<?php

namespace App\Http\Resources;

use App\Models\Product;

/**
 * Class ProductResource
 * @package App\Http\Resources
 */
class ProductResource extends AbstractConvertableResource
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
         * @var Product $resource
         */
        $resource = $this->resource;

        return [
            'id'          => $resource->getId(),
            'title'       => $resource->getTitle(),
            'description' => $resource->getDescription(),
            'price'       => $this->calculatePrice($resource->getPrice(), $resource->getCurrency()),
            'currency'    => $this->getCurrency(),
            'img'         => $resource->getImg(),
        ];
    }

}
