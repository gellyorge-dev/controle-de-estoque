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
        Schema::create('itens_de_quantidade', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_tipo')->constrained('tipos');
            $table->foreignId('id_fabricante')->constrained('fabricantes');
            $table->foreignId('id_localizacao')->constrained('localizacoes');
            $table->integer('quantidade');
            $table->string('observacao')->nullable();
            $table->unique(['id_tipo', 'id_fabricante', 'id_localizacao']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itens_de_quantidade');
    }
};
