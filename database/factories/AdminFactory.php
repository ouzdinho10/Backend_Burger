<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as FakerFactory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
        $factory->define(Model::class, function(Faker $faker){

        return [
            'nom' => 'admin',
            'prenom' => 'ouz',
            'email' => 'admin@gmail.com',
            'tel' => $faker->phoneNumber,
            'ville' => $faker->city,
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
            'remember_token' => Str::random(10),
        ];
    });


