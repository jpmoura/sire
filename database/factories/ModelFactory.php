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


// Fábricas de Usuario
$factory->define(App\Usuario::class, function (Faker\Generator $faker) {
    return [
        'cpf' => $faker->cpf,
        'nome' => $faker->name,
        'email' => $faker->safeEmail,
        'status' => 1,
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

// Fábrica de Bug
$factory->define(App\Bug::class, function (Faker\Generator $faker) {
    return [
        'titulo' => $faker->realText(10),
        'descricao' => $faker->realText(50),
        'status' => 1,
        'usuario_id' => function() {
            return factory(App\Usuario::class, 'normal')->create()->id;
        },
    ];
});

// Fabrica de FabricanteSoftware
$factory->define(App\FabricanteSoftware::class, function (Faker\Generator $faker) {
    return [
        'nome' => $faker->company,
    ];
});

// Fabrica de Software
$factory->define(App\Software::class, function (Faker\Generator $faker) {
    return [
        'nome' => $faker->streetName,
        'versao' => $faker->randomDigit,
        'status' => 1,
        'fabricante_software_id' => function () { return factory(App\FabricanteSoftware::class)->create()->id; }
    ];
});

// Fábrica de TipoRecurso
$factory->define(App\TipoRecurso::class, function (Faker\Generator $faker) {
    return [
        'nome' => $faker->jobTitle,
    ];
});