<?php

use Faker\Generator as Faker;

$factory->define(Laragento\Customer\Models\Customer::class, function (Faker $faker) {
    return [
        'website_id' => 1,
        'email' => $faker->unique()->safeEmail,
        'group_id' => 1,
        'prefix' => null,
        'firstname' => $faker->name,
        'middlename' => $faker->name,
        'lastname' => $faker->name,
        'dob' => '02.11.1923',
        'gender' => 1,
    ];
});
