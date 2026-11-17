<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\AuthorProfile;
use App\Models\Book;
use App\Models\Category;
use App\Support\ExemploConsulta;

/**
 * Página inicial: mapa do banco (tabelas, PK e FK) e o código de cada
 * relação lido direto dos models.
 */
class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'totais' => [
                'categories'      => Category::count(),
                'authors'         => Author::count(),
                'author_profiles' => AuthorProfile::count(),
                'books'           => Book::count(),
            ],
            'relacoes' => [
                ['N:1', 'belongsTo', 'Book', 'author', 'Um livro pertence a um autor (books.author_id → authors.id).'],
                ['N:1', 'belongsTo', 'Book', 'category', 'Um livro pertence a uma categoria (books.category_id → categories.id).'],
                ['1:N', 'hasMany', 'Author', 'books', 'Um autor tem muitos livros.'],
                ['1:N', 'hasMany', 'Category', 'books', 'Uma categoria tem muitos livros.'],
                ['1:1', 'hasOne', 'Author', 'profile', 'Um autor tem um perfil.'],
                ['1:1 (inverso)', 'belongsTo', 'AuthorProfile', 'author', 'Um perfil pertence a um autor (author_profiles.author_id → authors.id).'],
            ],
            'fonte' => fn (string $model, string $metodo) => ExemploConsulta::metodo('App\\Models\\'.$model, $metodo),
        ]);
    }
}
