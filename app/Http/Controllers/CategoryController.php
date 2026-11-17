<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('categorias.index', compact('categories'));
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
        ], [
            'required' => 'Preencha o campo :attribute.',
            'max'      => 'O campo :attribute passou do limite (:max caracteres).',
            'unique'   => 'Já existe uma categoria com esse :attribute.',
        ], [
            'name' => 'nome',
        ]);

        Category::create($data);

        return redirect()->route('categorias.index')->with('sucesso', 'Categoria cadastrada.');
    }
}
