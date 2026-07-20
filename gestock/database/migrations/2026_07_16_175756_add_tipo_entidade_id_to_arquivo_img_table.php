<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('arquivo_img', function (Blueprint $table) {
            $table->string('tipo', 50)->nullable()->after('hash');
            $table->unsignedBigInteger('entidade_id')->nullable()->after('tipo');
            $table->unique(['tipo', 'entidade_id']);
        });
    }

    public function down(): void
    {
        Schema::table('arquivo_img', function (Blueprint $table) {
            $table->dropUnique(['tipo', 'entidade_id']);
            $table->dropColumn(['tipo', 'entidade_id']);
        });
    }
};
