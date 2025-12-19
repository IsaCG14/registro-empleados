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
        Schema::create('asunto', function (Blueprint $table) {
            $table->id();
            $table->foreign('atencion_id')->references('id')->on('atendidos')->onDelete('cascade');
            $table->unsignedBigInteger('atencion_id');
            $table->foreign('patria_id')->references('id')->on('patria')->onDelete('cascade');
            $table->unsignedBigInteger('patria_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asunto');
    }
};
