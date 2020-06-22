<?php

namespace App\Notifications;

use App\Enums\CurrencyEnum;
use App\Models\Basket;
use App\Models\Order;
use App\Services\PriceFormatter;
use BenSampo\Enum\Enum;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreateForUser extends Notification
{
    use Queueable;

    /**
     * @var Order
     */
    private $order;

    /**
     * @var PriceFormatter
     */
    private $priceFormatter;

    /**
     * OrderCreateForUser constructor.
     * @param Order $order
     * @param PriceFormatter $priceFormatter
     */
    public function __construct(Order $order, PriceFormatter $priceFormatter)
    {
        $this->order = $order;
        $this->priceFormatter = $priceFormatter;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $message = (new MailMessage)
            ->line('Thank you for order.')
            ->line('Your order number is ' . $this->order->id)
            ->line('You have next position:');
        /**
         * @var Basket $basket
         */
        foreach ($this->order->basket as $basket) {
            $message->line($basket->getBasketRaw($this->order->getCurrency(), $this->priceFormatter));
        }

        if ($this->order->getDeliveryPrice() > 0) {
            $message->line('Deliver price: ' . $this->priceFormatter->handler($this->order->getDeliveryPrice(),
                    $this->order->getCurrency()));
        }

        $message->line('Your total price:' . $this->priceFormatter->handler($this->order->getTotalPrice(),
                $this->order->getCurrency()));

        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
