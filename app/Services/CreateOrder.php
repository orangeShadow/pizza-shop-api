<?php
declare(strict_types=1);


namespace App\Services;

use App\Deliveries\AbstractDelivery;
use App\Exceptions\AbstractPizzaException;
use App\Exceptions\CurrencyDifferenceException;
use App\Exceptions\PriceDiffernceException;
use App\Models\Order;
use App\Models\Basket;
use App\Models\Product;
use App\Notifications\OrderCreateForUser;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Notification;
use App\Models\User;

/**
 * Class CreateOrder
 * @package App\Services
 */
class CreateOrder
{
    /**
     * @var PriceConverting
     */
    private $priceConverting;

    /**
     * @var PriceFormatter
     */
    private $priceFormatter;

    /**
     * @var array
     */
    private $basketToSave = [];
    /**
     * @var int
     */
    private $basketTotalPrice = 0;

    /**
     * @var GetDelivery
     */
    private $deliveryService;


    public function __construct()
    {
        $this->priceConverting = new PriceConverting();
        $this->priceFormatter = new PriceFormatter();
        $this->deliveryService = new GetDelivery();
    }

    /**
     * @param array $basket
     * @param array $orderData
     * @param User $user
     * @return Order
     * @throws CurrencyDifferenceException
     * @throws PriceDiffernceException
     * @throws AbstractPizzaException
     */
    public function handler(array $basket, array $orderData, ?User $user): Order
    {
        \DB::beginTransaction();
        try {
            $currency = Arr::get($orderData, 'currency');

            $this->prepareBasket($basket, $currency);

            /**
             * @var AbstractDelivery $delivery
             */
            $delivery = $this->deliveryService->handler((int)Arr::get($orderData, 'deliveryId'));
            $deliveryPrice = $delivery->priceCalculate($this->basketTotalPrice, $currency);

            $order = Order::create([
                'name'           => Arr::get($orderData, 'name'),
                'email'          => Arr::get($orderData, 'email'),
                'phone'          => Arr::get($orderData, 'phone'),
                'address'        => Arr::get($orderData, 'address'),
                'user_id'        => is_null($user) ? null:$user->getId(),
                'delivery_id'    => Arr::get($orderData, 'deliveryId'),
                'delivery_price' => $deliveryPrice,
                'currency'       => $currency,
                'total_price'    => $this->basketTotalPrice + $deliveryPrice
            ]);
            $this->saveBasket($order);

            Notification::route('mail', $order->email)->notify(new OrderCreateForUser($order, $this->priceFormatter));

            \DB::commit();

            return $order;
        } catch (\Throwable $exception) {
            \DB::rollback();
            throw $exception;
        }
    }

    /**
     * Prepare basket for saving and calculate totalBasketPrice
     *
     * @param array $basket
     * @param string $orderCurrency
     * @throws CurrencyDifferenceException
     * @throws PriceDiffernceException
     */
    private function prepareBasket(array $basket, $orderCurrency)
    {
        $basketPrice = 0;

        foreach ($basket as $item) {
            if (Arr::get($item, 'currency') !== $orderCurrency) {
                throw new CurrencyDifferenceException();
            }

            $product = Product::findOrFail(Arr::get($item, 'productId'));

            $price = $this->priceConverting->handler($product->getPrice(), $product->getCurrency(), $orderCurrency);

            if ($price !== Arr::get($item, 'price')) {
                throw new PriceDiffernceException();
            }

            $quantity = Arr::get($item, 'quantity');

            $this->basketToSave[] = [
                'product_id' => Arr::get($item, 'productId'),
                'price'      => $price,
                'quantity'   => $quantity,
            ];

            $basketPrice += $price * $quantity;
        }

        $this->basketTotalPrice = $basketPrice;
    }

    /**
     * @param Order $order
     */
    private function saveBasket(Order $order): void
    {
        foreach ($this->basketToSave as $item) {
            Basket::create(array_merge($item, ['order_id' => $order->getId()]));
        }
    }
}
