<?php

namespace Database\Seeders;

use App\Models\Sucursal;
use App\Models\User;
use Database\Factories\UserFactory;
use Database\Factories\UserProfileFactory;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Henry Espinoza',
            'email' => 'henry@gmail.com',
            'password' => bcrypt('laravel'),
            'role' => 'admin',
            'created_at' => now(),
            'active'=>true

        ]);
        $user->profile()->create([
            'bio' => 'Creador del sistema',
            'ubicacion'=>'San Cristobal',
            'num_cel'=>'0424-7324441',
            'tipo_documento'=>'V',
            'num_documento'=>'23897456',
            'profesion' => 'Ingeniero',
        ]);
        foreach (range(1,10) as $i) {
            $user = UserFactory::new()->create([
                'active' => (bool)rand(0, 3),
                'created_at' => now()->subDays(rand(1, 90))
            ]);
            UserProfileFactory::factoryForModel('UserProfile')->state([
                'user_id' => $user->id,
            ])->create();
        }

    }
}
