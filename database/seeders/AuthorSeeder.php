<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        /*
         * created_at foi preenchido FORA da ordem alfabética e de id, de propósito:
         * assim dá para ver que latest()/oldest() sem coluna ordenam pela data de
         * CADASTRO (created_at), e não pelo id nem pelo nome.
         *
         * Dois casos especiais para estudar:
         *  - Cecília Meireles: NÃO tem perfil  -> $autor->profile devolve null (hasOne)
         *  - Ariano Suassuna:  NÃO tem livros  -> $autor->books devolve Collection vazia (hasMany)
         */
        $autores = [
            ['Machado de Assis', 'Brasil', '2026-03-10 09:00:00',
                ['Fundador da Academia Brasileira de Letras e mestre do realismo.', '1839-06-21', 'Rio de Janeiro']],
            ['Clarice Lispector', 'Brasil', '2026-01-05 14:30:00',
                ['Nasceu na Ucrânia e criou uma prosa introspectiva única.', '1920-12-10', 'Chechelnyk']],
            ['Carlos Drummond de Andrade', 'Brasil', '2026-02-20 11:15:00',
                ['Poeta modernista, também cronista de jornal por décadas.', '1902-10-31', 'Itabira']],
            ['Jorge Amado', 'Brasil', '2026-04-02 16:45:00',
                ['Romancista baiano, um dos autores brasileiros mais traduzidos.', '1912-08-10', 'Itabuna']],
            ['Cecília Meireles', 'Brasil', '2026-01-28 08:20:00', null],   // sem perfil
            ['Ariano Suassuna', 'Brasil', '2026-05-15 10:00:00',
                ['Dramaturgo e criador do Movimento Armorial.', '1927-06-16', 'João Pessoa']], // sem livros
        ];

        foreach ($autores as [$nome, $pais, $cadastro, $perfil]) {
            // create() respeita o $fillable; created_at/updated_at são
            // atribuídos depois porque não estão no $fillable.
            $autor = new Author(['name' => $nome, 'country' => $pais]);
            $autor->created_at = $cadastro;
            $autor->updated_at = $cadastro;
            $autor->save();

            if ($perfil) {
                [$bio, $nascimento, $cidade] = $perfil;

                // Criando PELA RELAÇÃO: o Laravel preenche author_id sozinho.
                // É o mesmo que AuthorProfile::create(['author_id' => $autor->id, ...]).
                $autor->profile()->create([
                    'bio'        => $bio,
                    'birth_date' => $nascimento,
                    'birth_city' => $cidade,
                ]);
            }
        }
    }
}
