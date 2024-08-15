<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Vehicule;
use App\Models\Command;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommandFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Command::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::pluck('id')->random(),
            'vehicule_id' => Vehicule::pluck('id')->random(),
            'dateL' => $this->faker->dateTime(),
            'dateR' => $this->faker->dateTime(),
            'notes' => $this->faker->text(300),
            'prixTTC' => $this->faker->numberBetween(1000, 5000),
        ];
    }
}
