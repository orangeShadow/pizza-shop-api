<?php

namespace App\Http\Resources;

use App\Models\Product;
use App\Services\PriceFormatter;
use Illuminate\Http\Resources\Json\JsonResource;

class BasketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $resource = $this->resource;
        $priceFormatter = new PriceFormatter();

        return [
            'id'       => $resource->id,
            'product'  => $resource->product->title,
            'quantity' => $resource->quantity,
            'price'    => $priceFormatter->handler(
                    $resource->getPrice(),
                    $resource->order->getCurrency()
            )
        ];
    }
}
