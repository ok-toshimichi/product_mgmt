<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Company;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {
    return [
        'company_name' => $faker->unique()->company,
        'street_address' => $faker->address,
        'representative_name' => $faker->name,
    ];
});
