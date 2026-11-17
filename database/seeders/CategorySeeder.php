<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // "Teatro" fica de propósito SEM livros: mostra que hasMany
        // devolve uma Collection VAZIA (e não null) quando não há filhos.
        foreach (['Romance', 'Poesia', 'Conto', 'Crônica', 'Teatro'] as $nome) {
            Category::create(['name' => $nome]);
        }
    }
}
