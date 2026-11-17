<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('livros.index'));

Route::resource('livros', BookController::class)
    ->only(['index', 'create', 'store', 'destroy'])
    ->parameters(['livros' => 'book']);
