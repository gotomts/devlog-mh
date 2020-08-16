<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Image;
use Faker\Generator as Faker;

$factory->define(Image::class, function (Faker $faker) {
    return [
        'url'        => $faker->url,
        'title'      => $faker->word,
        'alt'        => $faker->word,
        'created_by' => 1,
        'updated_by' => 1,
    ];
});
