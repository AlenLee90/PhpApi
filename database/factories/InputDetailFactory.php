<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\InputDetail::class, function (Faker $faker) {

    return [
		'user_id' => $faker->numberBetween($min = 1, $max = 5) ,
        'amount' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000),
        'category_id' => $faker->numberBetween($min = 1, $max = 3) ,
		'consumption_flag' => $faker->numberBetween($min = 0, $max = 1) ,
		'currency_id' => $faker->numberBetween($min = 1, $max = 5) ,
		'location' => $faker->streetName ,
		'comment' => $faker->jobTitle ,
		'image_url' => $faker->url ,
    ];
});
