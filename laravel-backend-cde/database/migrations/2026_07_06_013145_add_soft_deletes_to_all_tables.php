<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tipos', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('fabricantes', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('localizacoes', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('itens_de_quantidade', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('itens_patrimoniados', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('tipos', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('fabricantes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('localizacoes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('itens_de_quantidade', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('itens_patrimoniados', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
