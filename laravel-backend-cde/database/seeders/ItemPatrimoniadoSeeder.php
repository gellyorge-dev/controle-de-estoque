<?php

namespace Database\Seeders;

use App\Models\ItemPatrimoniado;
use Illuminate\Database\Seeder;

class ItemPatrimoniadoSeeder extends Seeder
{
    public function run(): void
    {
        ItemPatrimoniado::create([
            'patrimonio' => 1001,
            'id_tipo' => 1,
            'id_fabricante' => 1,
            'id_localizacao' => 1,
            'observacao' => 'Notebook corporativo',
        ]);

        ItemPatrimoniado::create([
            'patrimonio' => 1002,
            'id_tipo' => 1,
            'id_fabricante' => 1,
            'id_localizacao' => 2,
            'observacao' => 'Monitor externo',
        ]);

        ItemPatrimoniado::create([
            'patrimonio' => 2001,
            'id_tipo' => 2,
            'id_fabricante' => 1,
            'id_localizacao' => 3,
            'observacao' => 'Cadeira ergonômica',
        ]);

        ItemPatrimoniado::create([
            'patrimonio' => 3001,
            'id_tipo' => 3,
            'id_fabricante' => 2,
            'id_localizacao' => 2,
            'observacao' => 'Furadeira industrial',
        ]);
    }
}
