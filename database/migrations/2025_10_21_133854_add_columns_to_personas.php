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
        Schema::table('personas', function (Blueprint $table) {
            $table->integer('cedula');
            $table->unsignedBigInteger('id_parroquia');
            $table->foreign('id_parroquia')->references('id_parroquia')->on('parroquias');
            $table->string('correo', 255);
            $table->string('telefono', 100);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personas', function (Blueprint $table) {
            //
        });
    }
};
