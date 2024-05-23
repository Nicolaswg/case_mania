<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_compras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compra_id')
                ->references('id')
                ->on('compras')->onUpdate('CASCADE')->onDelete('CASCADE');
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
        Schema::dropIfExists('detalle_compras');
    }
}
