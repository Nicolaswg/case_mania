<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->name(),
            'direccion'=>$this->faker->address(),
            'tipo_documento'=>$this->faker->randomElement(['V','E','J']),
            'num_documento'=>$this->faker->randomNumber(7),
            'telefono'=>$this->faker->randomNumber(5),
            'email'=>$this->faker->safeEmail(),
            'status'=>$this->faker->randomElement(['active','inactive'])
        ];
    }
}
