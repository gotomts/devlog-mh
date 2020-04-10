<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'category_name' => "カテゴリー" . $faker->numberBetween($min = 1, $max = 10000),
        'user_id' => 1,
        'delete_flg' => null,
    ];
});
