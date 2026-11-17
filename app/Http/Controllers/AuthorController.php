<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::all();

        return view('autores.index', compact('authors'));
    }

    public function create()
    {
        return view('autores.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:60'],
        ], [
            'required' => 'Preencha o campo :attribute.',
            'max'      => 'O campo :attribute passou do limite (:max caracteres).',
        ], [
            'name'    => 'nome',
            'country' => 'país',
        ]);

        Author::create($data);

        return redirect()->route('autores.index')->with('sucesso', 'Autor cadastrado.');
    }
}
