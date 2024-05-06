<?php

namespace Database\Seeders;

use App\Models\Sucursal;
use Illuminate\Database\Seeder;

class SucursalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sucursal::create([
            'nombre'=>'Principal',
            'codigo'=>'PRIN-1',
            'estado'=>'tachira',
            'ciudad'=>'san cristobal'
        ]);
        Sucursal::create([
            'nombre'=>'Secundarea',
            'codigo'=>'SEC-1',
            'estado'=>'aragua',
            'ciudad'=>'maracay'
        ]);
    }
}
