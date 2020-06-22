<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Class Order
 * Because currency changeable  delivery price and s total sum can change,
 * so save all states for total price and delivery price
 *
 * @package App\Models
 */
class Order extends Model
{


    protected $fillable = ['name', 'user_id','email', 'address', 'phone', 'currency', 'delivery_id', 'delivery_price', 'total_price'];

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return int
     */
    public function getDeliveryPrice(): int
    {
        return $this->delivery_price;
    }

    /**
     * @return int
     */
    public function getTotalPrice(): int
    {
        return $this->total_price;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function basket()
    {
        return $this->hasMany(Basket::class);
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at->format('d.m.Y');
    }

    /**
     * @param Builder $query
     * @param Request $request
     */
    public function scopeSearch(Builder $query, Request $request): Builder
    {
        if (!is_null($request->user())) {
            $query->where('user_id', $request->user()->getId());
        }

        return $query;
    }
}
