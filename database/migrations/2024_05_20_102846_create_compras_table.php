<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proveedor_id')
                ->references('id')
                ->on('proveedors')->onUpdate('CASCADE');
            $table->foreignId('sucursal_id')
                ->references('id')->on('sucursals')->onUpdate('CASCADE');
            $table->float('tasa_bcv');
            $table->date('fecha_compra');
            $table->float('subtotal');
            $table->float('iva');
            $table->float('total');
            $table->boolean('status_carga')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compras');
    }
}
