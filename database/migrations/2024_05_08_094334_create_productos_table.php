<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->nullable()
                ->references('id')
                ->on('categorias')->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->foreignId('sucursal_id')
                ->references('id')->on('sucursals')->onUpdate('cascade');
            $table->integer('cantidad')->nullable();
            $table->integer('cantidad_devueltos')->nullable();
            $table->string('nombre');
            $table->string('photo',255)->nullable();
            $table->string('descripcion')->nullable();
            $table->string('status')->nullable();
            $table->float('precio_compra')->nullable();
            $table->integer('porcentaje_ganancia')->nullable()->default(30);
            $table->float('precio_venta')->nullable();
            $table->float('tasa_bcv')->nullable();
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
        Schema::dropIfExists('productos');
    }
}
