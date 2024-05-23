<?php

namespace Database\Seeders;

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
        Proveedor::factory()->count(5)->create();
    }
}
