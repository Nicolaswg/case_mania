<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->string('direccion');
            $table->string('referencia');
            $table->foreignId('venta_id')
                ->references('id')
                ->on('ventas')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreignId('user_id')->nullable()
                ->references('id')
                ->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->string('status');
            $table->float('costo_delivery');
            $table->string('detalles_entrega')->nullable();
            $table->date('fecha_entrega')->nullable();
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
        Schema::dropIfExists('deliveries');
    }
}
