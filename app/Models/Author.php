<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Autor (tabela "authors").
 *
 * Relações:
 *   1:N  um autor tem muitos livros -> books()
 *   1:1  um autor tem um perfil     -> profile()
 */
class Author extends Model
{
    protected $fillable = ['name', 'country'];

    /**
     * 1:N  ->  hasMany(Model)
     *
     * "Um autor TEM MUITOS livros."
     * FK deduzida: books.author_id (nome do model em snake_case + "_id").
     * Uso como PROPRIEDADE:  $autor->books          -> Collection (já executa a consulta)
     * Uso como MÉTODO:       $autor->books()->...   -> query builder (dá para encadear
     *                                                   latest(), where(), count()...)
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    /**
     * 1:1  ->  hasOne(Model)
     *
     * "Um autor TEM UM perfil."
     * FK deduzida: author_profiles.author_id
     * Uso: $autor->profile  -> um AuthorProfile OU null (se o autor não tiver perfil).
     * Por isso, na tela, use $autor->profile?->bio  (operador nullsafe "?->").
     *
     * Se a FK tivesse outro nome: $this->hasOne(AuthorProfile::class, 'writer_id');
     */
    public function profile(): HasOne
    {
        return $this->hasOne(AuthorProfile::class);
    }
}
