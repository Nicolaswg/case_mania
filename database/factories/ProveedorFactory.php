<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProveedorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre'=>$this->faker->company,
            'rif'=>$this->faker->creditCardNumber,
            'status'=>$this->faker->randomElement(['active','inactive']),
            'num_cel'=>$this->faker->phoneNumber,
            'tipo'=>$this->faker->randomElement(['v','j']),
        ];
    }
}
