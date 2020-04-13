<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => "カテゴリー" . $faker->numberBetween($min = 1, $max = 10000),
        'created_by' => 1,
        'updated_by' => 1,
    ];
});
