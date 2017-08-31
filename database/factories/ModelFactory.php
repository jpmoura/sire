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

$factory->define(App\Usuario::class, function (Faker\Generator $faker) {
    return [
        'nome' => $faker->name,
        'cpf' => $faker->cpf,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->defineAs(App\Usuario::class, 'admin', function ($faker) use ($factory) {
    $user = $factory->raw(App\Usuario::class);

    return array_merge($user, ['nivel' => 1]);
});

$factory->defineAs(App\Usuario::class, 'normal', function ($faker) use ($factory) {
    $user = $factory->raw(App\Usuario::class);

    return array_merge($user, ['nivel' => 2]);
});

$factory->defineAs(App\Usuario::class, 'especial', function ($faker) use ($factory) {
    $user = $factory->raw(App\Usuario::class);

    return array_merge($user, ['nivel' => 3]);
});