<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Seeder principal. Roda com:  php artisan migrate --seed
 *                 ou do zero:  php artisan migrate:fresh --seed
 *
 * A ORDEM importa pelo mesmo motivo das migrations: primeiro os "pais"
 * (categories, authors), depois os "filhos" que têm FK (author_profiles, books).
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            AuthorSeeder::class,   // cria autores e os perfis (1:1)
            BookSeeder::class,     // cria livros ligados a autor e categoria (N:1)
        ]);
    }
}
