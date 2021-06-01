<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(App\Models\Product::class, function (Faker\Generator\Faker $faker) {
    return [
        'img'         => $faker->imageUrl(400, 400),
        'title'       => implode(' ', $faker->words(2)),
        'description' => $faker->text(200),
        'price'       => $faker->numberBetween(1000, 2000),
        'currency'    => env('DEFAULT_CURRENCY', 'EUR')
    ];
});
