<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Tabela "authors" (autores)
|--------------------------------------------------------------------------
| É o centro do exemplo. Um autor:
|   - TEM MUITOS livros (1:N)   -> Author::hasMany(Book::class)
|   - TEM UM perfil      (1:1)   -> Author::hasOne(AuthorProfile::class)
|
| Repare que "authors" NÃO tem coluna apontando para books nem para
| author_profiles. Quem guarda a FK é sempre o lado "filho" (books e
| author_profiles têm a coluna author_id).
*/
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('country', 60);
            // created_at é a coluna que latest() e oldest() usam quando
            // você NÃO informa coluna nenhuma.
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('authors');
    }
};
