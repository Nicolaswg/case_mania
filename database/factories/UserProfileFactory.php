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
            'bio'=>$this->faker->sentence(10),
            'ubicacion'=>$this->faker->city,
            'num_cel'=>$this->faker->randomNumber(5),
            'tipo_documento'=>$this->faker->randomElement(['V','E','J']),
            'num_documento'=>$this->faker->randomNumber(8),
            'profesion'=>$this->faker->randomElement(['Licenciado','Ingeniero','Abogado','Comerciante']),
        ];
    }
}
