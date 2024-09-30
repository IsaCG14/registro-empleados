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
        Schema::create('hijos', function (Blueprint $table) {
            $table->id()->autoIncrement(); 
            $table->unsignedBigInteger("id_empleado");
            $table->unsignedBigInteger("id_persona");
            $table->foreign("id_empleado")->references("id")->on("empleados");
            $table->foreign("id_persona")->references("id")->on("personas");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hijos');
    }
};
