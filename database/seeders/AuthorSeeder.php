<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\AuthorProfile;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        $autores = [
            ['Machado de Assis', 'Brasil', '2026-03-10 09:00:00',
                ['Fundador da Academia Brasileira de Letras e mestre do realismo.', '1839-06-21', 'Rio de Janeiro']],
            ['Clarice Lispector', 'Brasil', '2026-01-05 14:30:00',
                ['Nasceu na Ucrânia e criou uma prosa introspectiva única.', '1920-12-10', 'Chechelnyk']],
            ['Carlos Drummond de Andrade', 'Brasil', '2026-02-20 11:15:00',
                ['Poeta modernista, também cronista de jornal por décadas.', '1902-10-31', 'Itabira']],
            ['Jorge Amado', 'Brasil', '2026-04-02 16:45:00',
                ['Romancista baiano, um dos autores brasileiros mais traduzidos.', '1912-08-10', 'Itabuna']],
            ['Cecília Meireles', 'Brasil', '2026-01-28 08:20:00', null],
            ['Ariano Suassuna', 'Brasil', '2026-05-15 10:00:00',
                ['Dramaturgo e criador do Movimento Armorial.', '1927-06-16', 'João Pessoa']],
        ];

        foreach ($autores as [$nome, $pais, $cadastro, $perfil]) {
            $autor = new Author(['name' => $nome, 'country' => $pais]);
            $autor->created_at = $cadastro;
            $autor->updated_at = $cadastro;
            $autor->save();

            if ($perfil) {
                [$bio, $nascimento, $cidade] = $perfil;

                AuthorProfile::create([
                    'author_id'  => $autor->id,
                    'bio'        => $bio,
                    'birth_date' => $nascimento,
                    'birth_city' => $cidade,
                ]);
            }
        }
    }
}
