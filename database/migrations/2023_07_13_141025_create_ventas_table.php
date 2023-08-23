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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->unsignedBigInteger('metodopago_id');
            $table->foreign('metodopago_id')->references('id')->on('metodopagos');
            $table->unsignedBigInteger('tipopago_id')->nullable();
            $table->foreign('tipopago_id')->references('id')->on('tipopagos');
            $table->date('fecha');
            $table->decimal('total',10,2)->nullable();
            $table->decimal('totalpagado',10,2)->nullable();
            //$table->boolean('envio')->default(false);
            $table->boolean('pago')->default(false);
            $table->boolean('estado')->default(false);
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
};
