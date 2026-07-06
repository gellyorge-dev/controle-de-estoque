<?php

namespace Database\Seeders;

use App\Models\Localizacao;
use Illuminate\Database\Seeder;

class LocalizacaoSeeder extends Seeder
{
    public function run(): void
    {
        Localizacao::create(['localizacao_nome' => 'Sala A']);
        Localizacao::create(['localizacao_nome' => 'Depósito']);
        Localizacao::create(['localizacao_nome' => 'Almoxarifado']);
    }
}
