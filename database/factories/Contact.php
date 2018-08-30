<?php

use Faker\Generator as Faker;
use App\Models\Contact;

$factory->define(Contact::class, function (Faker $faker) {
    return [
        "name" => $faker->name,
        "email" => $faker->email,
        "phone_number" => $faker->phoneNumber,
        "company" => $faker->company,
        "birthdate" => $faker->dateTimeThisCentury->format('Y-m-d'),
        "profile_image" => $faker->imageUrl,
        "address" =>[
            "address" => $faker->streetAddress,
            "state" => $faker->state,
            "number" =>  $faker->randomNumber(5, true),
            "city" => $faker->city
        ]
    ];
});
