<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicule>
 */
class VehiculeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = FakerFactory::create();

        return [
            'dateachat' => $this->faker->date(),
            'kmdefaut' => $this->faker->numberBetween(1000, 50000),
            'marque' => $faker->company,
            'model' => $faker->year,
            'type' => $faker->word,
            'prixJ' => $faker->randomNumber(),
            'dispo' => $faker->randomDigit(0, 1),
            'image' => $this->faker->imageUrl(200, 200),
            
        ];
    }
}

