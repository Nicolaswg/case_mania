<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venta_id')
                ->references('id')
                ->on('ventas')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('productos_nombres');
            $table->string('categorias_productos');
            $table->string('productos_ids');
            $table->string('cantidad');
            $table->string('costo_unitario');
            $table->string('subtotal');
            $table->string('photos');
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
        Schema::dropIfExists('detalle_ventas');
    }
}
