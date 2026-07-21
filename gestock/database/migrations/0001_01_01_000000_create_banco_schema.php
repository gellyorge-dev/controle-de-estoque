<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('unidade_org', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 150)->unique();
            $table->timestamps();
        });

        Schema::create('espaco_arm', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unidade_organizacional_id')->constrained('unidade_org')->restrictOnDelete()->cascadeOnUpdate();
            $table->string('nome', 150);
            $table->string('descricao', 255)->nullable();
            $table->timestamps();
        });

        Schema::create('marca_eqp', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100)->unique();
            $table->timestamps();
        });

        Schema::create('tipo_eqp', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100)->unique();
            $table->timestamps();
        });

        Schema::create('cond_eqp', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100)->unique();
            $table->timestamps();
        });

        Schema::create('perfil_usr', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100)->unique();
            $table->timestamps();
        });

        Schema::create('arquivo_img', function (Blueprint $table) {
            $table->id();
            $table->string('nome_arquivo', 255);
            $table->string('caminho', 500);
            $table->string('mime_type', 100)->nullable();
            $table->bigInteger('tamanho')->nullable();
            $table->string('hash', 255)->nullable();
            $table->timestamps();
        });

        Schema::create('usuario_sis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perfil_usuario_id')->constrained('perfil_usr');
            $table->foreignId('arquivo_imagem_id')->nullable()->constrained('arquivo_img');
            $table->string('nome_usuario', 150);
            $table->string('login_usuario', 100)->unique();
            $table->string('senha_usuario', 255);
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });

        Schema::create('equip_patrim', function (Blueprint $table) {
            $table->id();
            $table->integer('numero_patrimonio')->unique();
            $table->string('numero_serie', 150)->nullable();
            $table->foreignId('espaco_armazenamento_id')->constrained('espaco_arm');
            $table->foreignId('marca_equipamento_id')->nullable()->constrained('marca_eqp');
            $table->foreignId('tipo_equipamento_id')->nullable()->constrained('tipo_eqp');
            $table->foreignId('condicao_operacional_equipamento_id')->constrained('cond_eqp');
            $table->foreignId('arquivo_imagem_id')->nullable()->constrained('arquivo_img');
            $table->text('descricao_equipamento')->nullable();
            $table->boolean('informado_ao_patrimonio')->default(false);
            $table->boolean('patrimonio_esta_ativo')->default(true);
            $table->string('local_anterior', 255)->nullable();
            $table->text('observacoes_equipamento')->nullable();
            $table->timestamps();

            $table->index('numero_patrimonio', 'idx_equip_patrim_numero');
            $table->index('espaco_armazenamento_id', 'idx_equip_patrim_espaco');
        });

        Schema::create('item_estoque', function (Blueprint $table) {
            $table->id();
            $table->foreignId('espaco_armazenamento_id')->constrained('espaco_arm');
            $table->foreignId('arquivo_imagem_id')->nullable()->constrained('arquivo_img');
            $table->string('nome_item', 150);
            $table->text('descricao_item')->nullable();
            $table->integer('quantidade')->default(0);
            $table->text('observacoes_item')->nullable();
            $table->timestamps();

            $table->index('nome_item', 'idx_item_estoque_nome');
            $table->index('espaco_armazenamento_id', 'idx_item_estoque_espaco');
        });

        Schema::create('registro_aud', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_sistema_id')->constrained('usuario_sis');
            $table->string('nome_tabela', 100);
            $table->integer('identificador_registro');
            $table->string('tipo_acao', 30);
            $table->text('valor_anterior')->nullable();
            $table->text('valor_novo')->nullable();
            $table->text('observacao')->nullable();
            $table->timestamps();

            $table->index(['nome_tabela', 'identificador_registro'], 'idx_registro_aud_tabela');
        });

        DB::table('perfil_usr')->insert([
            ['id' => 1, 'nome' => 'Administrador', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nome' => 'Operador de Estoque', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nome' => 'Consulta', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('marca_eqp')->insert([
            ['id' => 1, 'nome' => 'Dell', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nome' => 'Lenovo', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nome' => 'HP', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'nome' => 'Samsung', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('tipo_eqp')->insert([
            ['id' => 1, 'nome' => 'Notebook', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nome' => 'Monitor', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nome' => 'Impressora', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'nome' => 'Nobreak', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('cond_eqp')->insert([
            ['id' => 1, 'nome' => 'Em uso', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nome' => 'Em manutenção', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nome' => 'Baixado', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'nome' => 'Reserva técnica', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('usuario_sis')->insert([
            'perfil_usuario_id' => 1,
            'nome_usuario' => 'admin',
            'login_usuario' => 'admin',
            'senha_usuario' => Hash::make('admin'),
            'ativo' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('registro_aud');
        Schema::dropIfExists('equip_patrim');
        Schema::dropIfExists('item_estoque');
        Schema::dropIfExists('usuario_sis');
        Schema::dropIfExists('arquivo_img');
        Schema::dropIfExists('perfil_usr');
        Schema::dropIfExists('cond_eqp');
        Schema::dropIfExists('tipo_eqp');
        Schema::dropIfExists('marca_eqp');
        Schema::dropIfExists('espaco_arm');
        Schema::dropIfExists('unidade_org');
    }
};
