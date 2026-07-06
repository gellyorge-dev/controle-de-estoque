<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            TipoSeeder::class,
            FabricanteSeeder::class,
            LocalizacaoSeeder::class,
            ItemDeQuantidadeSeeder::class,
            ItemPatrimoniadoSeeder::class,
        ]);
    }
}
