<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeguridadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seguridads', function (Blueprint $table) {
            $table->id();
            $table->string('pregunta_1')->nullable();
            $table->string('pregunta_2')->nullable();
            $table->string('respuesta_1')->nullable();
            $table->string('respuesta_2')->nullable();
            $table->foreignId('user_id')
                ->references('id')
                ->on('users')->onDelete('CASCADE')->onUpdate('CASCADE');
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
        Schema::dropIfExists('seguridads');
    }
}
