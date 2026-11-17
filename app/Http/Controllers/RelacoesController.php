<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\AuthorProfile;
use App\Models\Book;
use App\Models\Category;
use App\Support\ExemploConsulta;

/**
 * PARTE 2 DO QUADRO: relações de tabelas
 *
 *   N:1  belongsTo(Model)  -> "pertence a"   (quem tem a coluna _id)
 *   1:N  hasMany(Model)    -> "tem muitos"
 *   1:1  hasOne(Model)     -> "tem um"
 *   Eager loading: Model::with('relacionamento') -> carrega a relação ANTES,
 *   numa consulta só, evitando o problema N+1.
 *
 * Os métodos das relações estão em app/Models (Author, Book, AuthorProfile, Category).
 */
class RelacoesController extends Controller
{
    public function index()
    {
        $exemplos = [
            // ---------------------------------------------------------------
            // N:1 belongsTo, primeiro SEM with(), para ver o problema
            // ---------------------------------------------------------------
            ExemploConsulta::rodar(
                titulo: 'belongsTo SEM with(): o problema N+1',
                tag: 'N:1 belongsTo',
                explicacao: 'A consulta busca só os livros. Depois, no laço, cada <code>$livro->author</code> faz <b>mais uma consulta</b> ao banco (lazy loading). '
                    .'Resultado: 1 consulta dos livros + 1 por livro. Veja a contagem de SQL abaixo. Funciona, mas é lento e o avaliador nota.',
                consulta: fn () => Book::orderBy('title')->get(),
                linha: fn (Book $livro) => ['Livro' => $livro->title, 'Autor (belongsTo)' => $livro->author->name],
            ),

            // ---------------------------------------------------------------
            // N:1 belongsTo COM with()
            // ---------------------------------------------------------------
            ExemploConsulta::rodar(
                titulo: "belongsTo COM with('author'): eager loading",
                tag: 'E + R  with()',
                explicacao: 'Mesmo resultado, mas o <code>with(\'author\')</code> busca todos os autores de uma vez com <code>WHERE id IN (...)</code>. '
                    .'São só <b>2 consultas</b>, não importa se são 15 ou 15.000 livros. O nome passado no <code>with</code> é o <b>nome do método</b> da relação no model.',
                consulta: fn () => Book::with('author')->orderBy('title')->get(),
                linha: fn (Book $livro) => ['Livro' => $livro->title, 'Autor (belongsTo)' => $livro->author->name],
            ),

            // ---------------------------------------------------------------
            // Dois belongsTo de uma vez
            // ---------------------------------------------------------------
            ExemploConsulta::rodar(
                titulo: "Várias relações: with(['author', 'category'])",
                tag: 'E + R  with()',
                explicacao: 'Passe um array para carregar várias relações. Cada uma custa uma consulta a mais (total 3), em vez de 2 por livro.',
                consulta: fn () => Book::with(['author', 'category'])->latest('published_at')->get(),
                linha: fn (Book $livro) => [
                    'Livro'     => $livro->title,
                    'Autor'     => $livro->author->name,
                    'Categoria' => $livro->category->name,
                    'Publicado' => $livro->published_at->format('Y'),
                ],
            ),

            // ---------------------------------------------------------------
            // 1:N hasMany
            // ---------------------------------------------------------------
            ExemploConsulta::rodar(
                titulo: "hasMany: um autor e seus livros, with('books')",
                tag: '1:N hasMany',
                explicacao: '<code>$autor->books</code> é uma <b>Collection</b> (lista). Por isso dá para usar <code>count()</code>, <code>pluck()</code>, <code>join()</code>, <code>foreach</code>. '
                    .'Repare no Ariano Suassuna: ele não tem livros, e a Collection vem <b>vazia</b> (nunca <code>null</code>).',
                consulta: fn () => Author::with('books')->orderBy('name')->get(),
                linha: fn (Author $autor) => [
                    'Autor'      => $autor->name,
                    'Qtd.'       => $autor->books->count(),
                    'Livros (hasMany)' => $autor->books->pluck('title')->join(', ') ?: '(nenhum)',
                ],
            ),

            // ---------------------------------------------------------------
            // 1:1 hasOne
            // ---------------------------------------------------------------
            ExemploConsulta::rodar(
                titulo: "hasOne: um autor e o seu perfil, with('profile')",
                tag: '1:1 hasOne',
                explicacao: '<code>$autor->profile</code> é <b>um</b> objeto, ou <code>null</code> se não existir. A Cecília Meireles não tem perfil: '
                    .'sem o <code>?-></code> (nullsafe) a página daria erro "Attempt to read property on null".',
                consulta: fn () => Author::with('profile')->orderBy('name')->get(),
                linha: fn (Author $autor) => [
                    'Autor'      => $autor->name,
                    'Nascimento' => $autor->profile?->birth_date->format('d/m/Y') ?? '(sem perfil)',
                    'Cidade'     => $autor->profile?->birth_city ?? '-',
                    'Bio (hasOne)' => $autor->profile?->bio ?? '-',
                ],
            ),

            // ---------------------------------------------------------------
            // Inverso do 1:1 (belongsTo)
            // ---------------------------------------------------------------
            ExemploConsulta::rodar(
                titulo: "O caminho inverso do 1:1: AuthorProfile belongsTo Author",
                tag: 'N:1 belongsTo',
                explicacao: 'Toda relação tem dois lados. A tabela que guarda a FK (<code>author_profiles.author_id</code>) usa <code>belongsTo</code>; a outra usa <code>hasOne</code> ou <code>hasMany</code>.',
                consulta: fn () => AuthorProfile::with('author')->oldest('birth_date')->get(),
                linha: fn (AuthorProfile $perfil) => [
                    'Nascimento' => $perfil->birth_date->format('d/m/Y'),
                    'Autor (belongsTo)' => $perfil->author->name,
                ],
            ),

            // ---------------------------------------------------------------
            // Relação aninhada com ponto
            // ---------------------------------------------------------------
            ExemploConsulta::rodar(
                titulo: "Aninhado: with('books.author')",
                tag: 'E + R  with()',
                explicacao: 'O ponto entra "dentro" da relação: carrega as categorias, os livros de cada categoria e o autor de cada livro. 3 consultas no total. '
                    .'Teatro aparece vazio porque não tem livros.',
                consulta: fn () => Category::with('books.author')->orderBy('name')->get(),
                linha: fn (Category $categoria) => [
                    'Categoria' => $categoria->name,
                    'Livros e autores' => $categoria->books
                        ->map(fn ($livro) => $livro->title.' ('.$livro->author->name.')')
                        ->join('; ') ?: '(nenhum)',
                ],
            ),

            // ---------------------------------------------------------------
            // Juntando as duas partes do quadro
            // ---------------------------------------------------------------
            ExemploConsulta::rodar(
                titulo: 'Juntando tudo: with() + ordenação DENTRO da relação',
                tag: 'with + oldest',
                explicacao: 'Dá para passar uma função no <code>with</code> e ordenar os filhos. Aqui: autores em ordem alfabética, cada um com o perfil e com os livros '
                    .'do mais antigo para o mais novo (<code>oldest(\'published_at\')</code>).',
                consulta: fn () => Author::with([
                    'profile',
                    'books' => fn ($query) => $query->oldest('published_at'),
                ])->orderBy('name')->get(),
                linha: fn (Author $autor) => [
                    'Autor'  => $autor->name,
                    'Cidade' => $autor->profile?->birth_city ?? '-',
                    'Livros (do mais antigo ao mais novo)' => $autor->books
                        ->map(fn ($livro) => $livro->published_at->format('Y').' '.$livro->title)
                        ->join(' → ') ?: '(nenhum)',
                ],
            ),

            // ---------------------------------------------------------------
            // Relação como MÉTODO (query builder) em um único model
            // ---------------------------------------------------------------
            ExemploConsulta::rodar(
                titulo: 'Propriedade x método: $autor->books()->latest(...)',
                tag: '1:N hasMany',
                explicacao: '<code>$autor->books</code> (sem parênteses) traz <b>todos</b> os livros. <code>$autor->books()</code> (com parênteses) devolve uma <b>consulta</b> '
                    .'que ainda aceita <code>latest</code>, <code>where</code>, <code>take</code>... Aqui: os 2 livros mais recentes do Machado de Assis.',
                consulta: fn () => Author::where('name', 'Machado de Assis')->first()->books()->latest('published_at')->take(2)->get(),
                linha: fn (Book $livro) => ['Livro' => $livro->title, 'Publicado em' => $livro->published_at->format('d/m/Y')],
            ),

            // ---------------------------------------------------------------
            // Bônus: withCount
            // ---------------------------------------------------------------
            ExemploConsulta::rodar(
                titulo: "Bônus: withCount('books') + orderBy no total",
                tag: 'bônus',
                explicacao: 'Quando você só precisa da <b>quantidade</b>, <code>withCount</code> cria a coluna <code>books_count</code> com um subselect, sem trazer os livros. '
                    .'Dá para ordenar por ela: ranking de quem tem mais livros.',
                consulta: fn () => Author::withCount('books')->orderBy('books_count', 'desc')->orderBy('name')->get(),
                linha: fn (Author $autor) => ['Autor' => $autor->name, 'books_count' => $autor->books_count],
            ),
        ];

        return view('relacoes', ['exemplos' => $exemplos]);
    }
}
