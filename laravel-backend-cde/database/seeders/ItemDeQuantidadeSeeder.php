<?php

namespace Database\Seeders;

use App\Models\ItemDeQuantidade;
use Illuminate\Database\Seeder;

class ItemDeQuantidadeSeeder extends Seeder
{
    public function run(): void
    {
        ItemDeQuantidade::create([
            'id_tipo' => 1,
            'id_fabricante' => 1,
            'id_localizacao' => 1,
            'quantidade' => 15,
            'observacao' => 'Monitores 24 polegadas',
        ]);

        ItemDeQuantidade::create([
            'id_tipo' => 1,
            'id_fabricante' => 1,
            'id_localizacao' => 2,
            'quantidade' => 8,
            'observacao' => 'Teclados sem fio',
        ]);

        ItemDeQuantidade::create([
            'id_tipo' => 2,
            'id_fabricante' => 1,
            'id_localizacao' => 3,
            'quantidade' => 3,
            'observacao' => 'Mesas de escritório',
        ]);

        ItemDeQuantidade::create([
            'id_tipo' => 3,
            'id_fabricante' => 2,
            'id_localizacao' => 2,
            'quantidade' => 20,
            'observacao' => 'Chaves de fenda',
        ]);

        ItemDeQuantidade::create([
            'id_tipo' => 3,
            'id_fabricante' => 2,
            'id_localizacao' => 3,
            'quantidade' => 5,
            'observacao' => 'Martelos',
        ]);
    }
}
