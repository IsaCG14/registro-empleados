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
        Schema::create('carnets', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string("codigo", 255);
            $table->string("serial", 255);
            $table->unsignedBigInteger("id_empleado");
            $table->foreign("id_empleado")->references("id")->on("empleados");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carnets');
    }
};