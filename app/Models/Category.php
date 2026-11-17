<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Categoria de livro (tabela "categories").
 *
 * Relação: 1 categoria -> N livros (1:N).
 */
class Category extends Model
{
    protected $fillable = ['name'];

    /**
     * 1:N  ->  hasMany(Model)
     *
     * "Uma categoria TEM MUITOS livros."
     * O Laravel deduz a FK pelo nome deste model: category_id na tabela books.
     * Uso: $categoria->books   (Collection de Book, pode vir vazia)
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
