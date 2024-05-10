<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Categoria::create([
            'nombre'=>'forros',
        ]);
        Categoria::create([
            'nombre'=>'celulares',
        ]);
        Categoria::create([
            'nombre'=>'audifonos',
        ]);

    }
}
