<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ubicacion'=>$this->faker->city,
            'num_cel'=>$this->faker->randomNumber(5),
            'tipo_documento'=>$this->faker->randomElement(['V','E','J']),
            'num_documento'=>$this->faker->randomNumber(8),
            'sucursal_id'=>random_int(1,2)
        ];
    }
}
