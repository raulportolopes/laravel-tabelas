<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrdenacaoController;
use App\Http\Controllers\RelacoesController;
use Illuminate\Support\Facades\Route;

/*
| Rotas da aplicação. Os nomes (->name) são usados nas views com route('...'),
| assim os links funcionam mesmo publicados numa subpasta (/tabelas).
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/ordenacao', [OrdenacaoController::class, 'index'])->name('ordenacao');
Route::get('/relacoes', [RelacoesController::class, 'index'])->name('relacoes');
