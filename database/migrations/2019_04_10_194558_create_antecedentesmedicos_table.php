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
        Schema::create('antecedentesmedicos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tipoantecedentemedico_id');
            $table->foreign('tipoantecedentemedico_id')->references('id')->on('tipoantecedentesmedicos');
            $table->string('descripcion',150);
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
        Schema::dropIfExists('antecedentesmedicos');
    }
};
