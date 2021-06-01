<?php

use Illuminate\Database\Seeder;

class ProductSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\Product::truncate();
        $pizza = [
            [
                'title'       => 'Sicilia',
                'description' => 'Ham, serval, mushrooms, tomatoes, caramel, Mozzarella cheese',
                'img'         => 'imgs/sicilia.jpg',
                'currency'    => 'EUR',
                'price'       => 249,
            ],
            [
                'title'       => 'Four cheese',
                'description' => 'Mozzarella, Parmesan, Feta, Mozzarella in brine, Sous',
                'img'         => 'imgs/4_cheese.jpg',
                'currency'    => 'EUR',
                'price'       => 926,
            ],
            [
                'title'       => 'Margaret',
                'description' => 'Tomatoes, feta cheese, mozzarella, tomato sauce, provencal herbs',
                'img'         => 'imgs/margarita.jpg',
                'currency'    => 'EUR',
                'price'       => 249,
            ],
            [
                'title'       => 'Pepperoni',
                'description' => 'Pepperoni, tomatoes, jalapeno pepper, tomato sauce',
                'img'         => 'imgs/pepperoni.jpg',
                'currency'    => 'EUR',
                'price'       => 249,
            ],
            [
                'title'       => 'Pepperoni and ham',
                'description' => 'Smoked carbonade, ham, pepperoni,',
                'img'         => 'imgs/pepperoni-and-ham.jpg',
                'currency'    => 'EUR',
                'price'       => 1003,
            ],
            [
                'title'       => 'Grill',
                'description' => 'Turkey sous-view, ham, tomatoes, grilled sauce, mozzarella',
                'img'         => 'imgs/grill.jpg',
                'currency'    => 'EUR',
                'price'       => 900,
            ],
            [
                'title'       => 'Salmon and Shrimp',
                'description' => 'Salmon, shrimp tiger, tomatoes, caramel onion, feta cheese, sauce, mozzarel cheese',
                'img'         => 'imgs/salmon_shrimp.jpg',
                'currency'    => 'EUR',
                'price'       => 1054,
            ],
            [
                'title'       => 'Countryside',
                'description' => 'Chicken fillet, mozzarella cheese, smoked carbonade, pickles, champagne, green onions, tomatoes, red onions, tomato sauce',
                'img'         => 'imgs/countryside.jpg',
                'currency'    => 'EUR',
                'price'       => 803,
            ]
        ];
        foreach ($pizza as $item){
            App\Models\Product::create($item);
        }
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
