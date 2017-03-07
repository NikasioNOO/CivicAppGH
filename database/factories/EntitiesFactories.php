<?php

/*
|--------------------------------------------------------------------------
| Entities Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use Illuminate\Support\Collection;

App::bind('CivicApp\Entities\Auth\AppUser',function()
{
    return new CivicApp\Entities\Auth\AppUser(new Collection());
});

 App::bind('CivicApp\Entities\Auth\Role',function()
{
    return new CivicApp\Entities\Auth\Role(new Collection());
});

$factory->define(CivicApp\Entities\Auth\AppUser::class, function ($faker) {
    return [
        'id' => $faker->unique()->randomDigit,
        'first_name' => $faker->name,
        'last_name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});


$factory->define(CivicApp\Entities\Auth\Role::class, function ($faker) {
    return [
        'id' => $faker->unique()->randomDigit,
        'role_name' => str_random(20)
    ];
});