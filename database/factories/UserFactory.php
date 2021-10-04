<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Role;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;

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

$factory->define(User::class, function (Faker $faker) {
    $adminIds = Role::query()->pluck('id');

    return [
        'name' => $faker->name(),
        'username' => $faker->userName,
        'password' => $faker->password(),
        'role_id' => Arr::random($adminIds->toArray()),
    ];
});
