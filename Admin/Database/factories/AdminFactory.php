<?php


use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Laragento\Admin\Models\AdminRole;
use Laragento\Admin\Models\AdminUser;

/** @var \Illuminate\Database\Eloquent\Factory $factory **/

$factory->define(AdminUser::class, function (Faker $faker) {
    return [
        'email' => 'test@test.com',
        'name' => 'admin',
        'password' => Hash::make('secret')
    ];
});

$factory->define(AdminRole::class, function (Faker $faker) {
    return [
        'name' => 'user',
    ];
});

