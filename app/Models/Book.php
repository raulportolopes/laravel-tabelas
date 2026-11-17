<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Livro (tabela "books").
 *
 * Relações:
 *   N:1  muitos livros pertencem a um autor      -> author()
 *   N:1  muitos livros pertencem a uma categoria -> category()
 */
class Book extends Model
{
    protected $fillable = ['author_id', 'category_id', 'title', 'pages', 'published_at'];

    protected $casts = [
        'published_at' => 'date',   // vira Carbon: $livro->published_at->format('d/m/Y')
    ];

    /**
     * N:1  ->  belongsTo(Model)
     *
     * "Um livro PERTENCE A um autor." (muitos livros -> 1 autor)
     * O Laravel usa o NOME DO MÉTODO + "_id" para achar a FK: author() -> author_id.
     * Uso: $livro->author->name
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    /**
     * N:1  ->  belongsTo(Model)
     *
     * "Um livro PERTENCE A uma categoria."  FK: category_id
     * Uso: $livro->category->name
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
