<?php

use Faker\Generator as Faker;

$factory->define(Laragento\Customer\Models\Address::class, function (Faker $faker) {
    return [
        'is_active' => 1,
        'firstname' => $faker->name,
        'middlename' => $faker->name,
        'lastname' => $faker->name,
        'company' => $faker->company,
        'street' => $faker->streetName,
        'city' => $faker->city,
        'postcode' => $faker->postcode,
        'region_id' => 115,
        'country_id' => "CH",
        'prefix' => null,
        'suffix' => null,
        'telephone' => $faker->phoneNumber,
        'fax' => $faker->phoneNumber,
        'parent_id' => factory(\Laragento\Customer\Models\Customer::class)->create()->entity_id
    ];
});
