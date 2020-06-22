<?php

namespace App\Models;

use App\Contacts\PriceConvertible;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * @package App\Models
 */
class Product extends Model implements PriceConvertible
{
    /**
     * @var array
     */
    protected $fillable = ['title', 'description', 'price', 'img', 'currency'];

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get public available method
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Get public available method
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getImg(): string
    {
        return url($this->img);
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

}
