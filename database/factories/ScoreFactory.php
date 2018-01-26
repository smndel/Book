<?php

use Faker\Generator as Faker;

$factory->define(App\Score::class, function (Faker $faker) {
    return [
        'book_id'=> $faker->numberBetween($min = 1, $max = 30),
        'vote'=> $faker->numberBetween($min = 0, $max = 5),
        'ip'=>$faker->ipv4
    ];
});
