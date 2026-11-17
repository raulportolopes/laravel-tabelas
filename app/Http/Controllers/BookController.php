<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();

        return view('livros.index', compact('books'));
    }

    public function create()
    {
        $authors = Author::all();
        $categories = Category::all();

        return view('livros.create', compact('authors', 'categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'author_id'    => ['required', 'integer', 'exists:authors,id'],
            'category_id'  => ['required', 'integer', 'exists:categories,id'],
            'pages'        => ['required', 'integer', 'min:1', 'max:65535'],
            'published_at' => ['required', 'date'],
        ], [
            'required' => 'Preencha o campo :attribute.',
            'integer'  => 'O campo :attribute precisa ser um número inteiro.',
            'min'      => 'O campo :attribute precisa ser no mínimo :min.',
            'max'      => 'O campo :attribute passou do limite (:max).',
            'exists'   => 'Selecione um valor válido para :attribute.',
            'date'     => 'Informe uma data válida em :attribute.',
        ], [
            'title'        => 'título',
            'author_id'    => 'autor',
            'category_id'  => 'categoria',
            'pages'        => 'páginas',
            'published_at' => 'data de publicação',
        ]);

        Book::create($data);

        return redirect()->route('livros.index')->with('sucesso', 'Livro cadastrado.');
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('livros.index')->with('sucesso', 'Livro excluído.');
    }
}
