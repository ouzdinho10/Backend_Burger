<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Burger>
 */
class BurgerFactory extends Factory
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
            'nom' => $faker->word,
            'description' => $this->faker->paragraph(),
            'prix' => $faker->numberBetween($min = 1000, $max = 9000),
            'status' => $faker->randomElement(['active','archived']),
            'image' => $this->faker->imageUrl(200, 200),
        ];
    }
}
