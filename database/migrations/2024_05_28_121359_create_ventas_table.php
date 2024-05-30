<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')
                ->references('id')
                ->on('clientes')->onUpdate('CASCADE');
            $table->foreignId('sucursal_id')
                ->references('id')->on('sucursals')->onUpdate('CASCADE');
            $table->date('fecha_venta');
            $table->float('tasa_bcv');
            $table->float('subtotal_dolar');
            $table->float('iva_dolar');
            $table->float('total_dolar');
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
        Schema::dropIfExists('ventas');
    }
}
