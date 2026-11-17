<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Tabela "books" (livros) - lado "N" de duas relações
|--------------------------------------------------------------------------
|   N livros PERTENCEM A 1 autor      -> Book::belongsTo(Author::class)
|   N livros PERTENCEM A 1 categoria  -> Book::belongsTo(Category::class)
|
| Ordem das migrations importa: books só pode ser criada DEPOIS de
| authors e categories, porque a FK precisa que a tabela-pai já exista.
| Por isso os nomes dos arquivos começam com data/numeração.
*/
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();

            // restrictOnDelete(): o banco NÃO deixa apagar um autor que
            // ainda tem livros (protege os dados). Compare com o
            // cascadeOnDelete() usado em author_profiles.
            $table->foreignId('author_id')->constrained()->restrictOnDelete();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();

            $table->string('title');
            $table->unsignedSmallInteger('pages');

            // Data de publicação: vamos ordenar por ela com
            // oldest('published_at') e latest('published_at').
            $table->date('published_at');

            $table->timestamps();   // created_at = data de CADASTRO no sistema
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
