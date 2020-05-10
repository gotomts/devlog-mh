<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'url' => $faker->unique()->word,
        'title' => implode($faker->words($nb=3, $asText=false)),
        'description' => $faker->text($maxNbChars=124),
        'keyword' => implode($faker->words($nb=5, $asText=false)),
        'content' => implode($faker->paragraphs($nb=3, $asText=false)),
        'status_id' => $faker->numberBetween($min=1, $max=2),
        'category_id' => $faker->numberBetween($min=1, $max=5),
        'created_by' => 1,
        'updated_by' => 1,
    ];
});
