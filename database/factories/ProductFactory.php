<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'company_id' => $faker->numberBetween($min = 1, $max = 5),
        'product_name' => $faker->unique()->word,
        'price' => $faker->numberBetween($min = 100, $max = 2000),
        'stock' => $faker->numberBetween($min = 10, $max = 300),
        'comment' => $faker->realText,
    ];
});
