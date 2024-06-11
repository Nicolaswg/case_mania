<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicioTecnicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicio_tecnicos', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha_recibido');
            $table->string('falla');
            $table->string('productos');
            $table->string('cantidad');
            $table->string('user');
            $table->string('serial');
            $table->foreignId('cliente_id')
                ->references('id')
                ->on('clientes')->onUpdate('CASCADE');
            $table->string('status');
            $table->float('costo_dolar')->nullable();
            $table->float('costo_bolivar')->nullable();
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
        Schema::dropIfExists('servicio_tecnicos');
    }
}
