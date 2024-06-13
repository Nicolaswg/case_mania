<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('ubicacion');
            $table->string('num_cel');
            $table->string('tipo_documento');
            $table->string('num_documento')->unique();
            $table->foreignId('user_id')
                ->references('id')
                ->on('users')->onDelete('CASCADE');
            $table->foreignId('sucursal_id')
                ->references('id')->on('sucursals');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_profiles');
    }
}
