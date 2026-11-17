<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Perfil do autor (tabela "author_profiles").
 * É o lado "filho" da relação 1:1: é aqui que fica a coluna author_id.
 */
class AuthorProfile extends Model
{
    protected $fillable = ['author_id', 'bio', 'birth_date', 'birth_city'];

    // Converte a coluna em objeto Carbon (data), permitindo ->format('d/m/Y').
    protected $casts = [
        'birth_date' => 'date',
    ];

    /**
     * Inverso do hasOne  ->  belongsTo(Model)
     *
     * "Este perfil PERTENCE A um autor."
     * Regra de bolso: QUEM TEM A COLUNA _id USA belongsTo.
     * Uso: $perfil->author->name
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }
}
