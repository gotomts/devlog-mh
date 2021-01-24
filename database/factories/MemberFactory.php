<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Member;
use Illuminate\Support\Str;
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

$factory->define(Member::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $faker->password($minLength=8, $maxLength=16),
        'remember_token' => Str::random(10),
        'created_by' => 1,
        'updated_by' => 1,
    ];
});
