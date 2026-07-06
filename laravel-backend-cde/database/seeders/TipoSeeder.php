<?php

namespace Database\Seeders;

use App\Models\Tipo;
use Illuminate\Database\Seeder;

class TipoSeeder extends Seeder
{
    public function run(): void
    {
        Tipo::create(['nome_tipo' => 'Eletrônico']);
        Tipo::create(['nome_tipo' => 'Móvel']);
        Tipo::create(['nome_tipo' => 'Ferramenta']);
    }
}
