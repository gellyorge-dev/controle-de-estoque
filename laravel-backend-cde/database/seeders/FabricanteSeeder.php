<?php

namespace Database\Seeders;

use App\Models\Fabricante;
use Illuminate\Database\Seeder;

class FabricanteSeeder extends Seeder
{
    public function run(): void
    {
        Fabricante::create(['nome_fabricante' => 'Samsung']);
        Fabricante::create(['nome_fabricante' => 'Tramontina']);
    }
}
