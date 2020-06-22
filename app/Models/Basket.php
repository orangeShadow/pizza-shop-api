<?php

namespace App\Models;

use App\Enums\CurrencyEnum;
use App\Services\PriceFormatter;
use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    protected $fillable = ['product_id', 'price', 'quantity', 'currency', 'order_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * Get String for letter
     * @param string|null $currency
     * @param PriceFormatter| null $priceFormatter
     * @return string
     */
    public function getBasketRaw(?string $currency = null, ?PriceFormatter $priceFormatter = null)
    {
        if (is_null($priceFormatter)) {
            $priceFormatter = new PriceFormatter();
        }

        if (is_null($currency)) {
            $currency = $this->order->getCurrency();
        }

        return $this->product->title . ' x '
            . $this->getQuantity() . ' - ' . $priceFormatter->handler($this->getPrice(), $currency);

    }
}

