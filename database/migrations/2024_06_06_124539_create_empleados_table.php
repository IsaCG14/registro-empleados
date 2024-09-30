<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->integer("cedula");
            $table->string("direccion", 255);
            $table->string("correo", 255);
            $table->string("telefono", 20);
            $table->string("cargo", 200);
            $table->date("fecha_ingreso");
            $table->integer("nro_hijos")->default(0);
            $table->integer("peso");
            $table->string("talla_camisa");
            $table->integer("talla_pantalon");
            $table->integer("talla_zapato");
            $table->string("patologia")->nullable(true);
            $table->string("centro_electoral", 255);
            $table->unsignedBigInteger("area");
            $table->unsignedBigInteger("id_persona");
            $table->foreign("id_persona")->references("id")->on("personas");
            $table->foreign("area")->references("id")->on("areas");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
