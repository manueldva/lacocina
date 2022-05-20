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
        Schema::create('viandaventadetalles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('viandaventa_id');
            $table->foreign('viandaventa_id')->references('id')->on('viandaventas');
            $table->decimal('precio', $precision = 10, $scale = 2);
            $table->integer('cantidad');
            $table->integer('cantidadenvios')->default(0);
            $table->decimal('precioenvio', $precision = 10, $scale = 2);
            //$table->boolean('entregado')->default(false);
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
        Schema::dropIfExists('viandaventadetalles');
    }
};
