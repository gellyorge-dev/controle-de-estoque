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
        Schema::create('itens_patrimoniados', function (Blueprint $table) {
            $table->id();
            $table->integer('patrimonio')->unique();
            $table->foreignId('id_tipo')->constrained('tipos');
            $table->foreignId('id_fabricante')->constrained('fabricantes');
            $table->foreignId('id_localizacao')->constrained('localizacoes');
            $table->string('observacao')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itens_patrimoniados');
    }
};
