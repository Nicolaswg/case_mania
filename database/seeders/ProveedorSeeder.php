<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Proveedor;
use Database\Factories\ProveedorFactory;
use Illuminate\Database\Seeder;

class ProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categorias=Categoria::query()->get();
        Proveedor::factory()->count(5)->state([
            'categoria_id'=>rand(1,count($categorias))
        ])->create();
    }
}
