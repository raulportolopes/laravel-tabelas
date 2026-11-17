<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('livros.index'));

Route::resource('livros', BookController::class)
    ->only(['index', 'create', 'store', 'destroy'])
    ->parameters(['livros' => 'book']);

Route::resource('autores', AuthorController::class)
    ->only(['index', 'create', 'store']);

Route::resource('categorias', CategoryController::class)
    ->only(['index', 'create', 'store']);
