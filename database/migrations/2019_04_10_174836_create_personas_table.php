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
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('documento',20)->nullable();
            $table->string('apellido',100);
            $table->string('nombre',100);
            $table->date('fechanacimiento')->nullable();
            $table->string('domicilio',200)->nullable();
            $table->string('telefono',20)->nullable();
            $table->string('email',150)->nullable();
            $table->string('otrocontacto',300)->nullable();
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
        Schema::dropIfExists('personas');
    }
};
