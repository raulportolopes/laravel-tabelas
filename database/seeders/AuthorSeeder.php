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
            ['Graciliano Ramos', 'Brasil', '2026-02-11 13:00:00',
                ['Autor de Vidas Secas e de São Bernardo.', '1892-10-27', 'Quebrangulo']],
            ['Rachel de Queiroz', 'Brasil', '2026-03-22 15:40:00',
                ['Primeira mulher eleita para a Academia Brasileira de Letras.', '1910-11-17', 'Fortaleza']],
            ['Lygia Fagundes Telles', 'Brasil', '2026-04-18 09:25:00', null],
            ['José Saramago', 'Portugal', '2026-01-15 17:05:00',
                ['Prêmio Nobel de Literatura de 1998.', '1922-11-16', 'Azinhaga']],
            ['Monteiro Lobato', 'Brasil', '2026-05-03 11:50:00', null],
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
