<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('equip_patrim', function (Blueprint $table) {
            $table->bigInteger('numero_patrimonio')->change();
        });
    }

    public function down(): void
    {
        Schema::table('equip_patrim', function (Blueprint $table) {
            $table->integer('numero_patrimonio')->change();
        });
    }
};
