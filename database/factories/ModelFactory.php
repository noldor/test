<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;
    static $role;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'role' => $role ?: $role = 'User',
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Calculation::class, function (Faker\Generator $faker) {
    static $userId;
    return [
        'name' => $faker->words(5, true),
        'source' => $faker->words(100, true),
        'user_id' => $userId ?: $userId = 1,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\SecretCode::class, function (Faker\Generator $faker) {
    return [
        'calculation_id' => $faker->numberBetween(1, 10),
        'value' => $faker->numberBetween(0, 1000),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime
    ];
});
