<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('viandas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tipovianda_id');
            $table->foreign('tipovianda_id')->references('id')->on('tipoviandas');
            $table->string('descripcion',250);
            $table->boolean('activo')->default(true);
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
        Schema::dropIfExists('viandas');
    }
};
