<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Tabela "author_profiles" (perfil do autor) - relação 1:1
|--------------------------------------------------------------------------
|   um autor TEM UM perfil          -> Author::hasOne(AuthorProfile::class)
|   um perfil PERTENCE A um autor   -> AuthorProfile::belongsTo(Author::class)
|
| O que garante o "1:1" no banco é o ->unique() na FK: o mesmo autor não
| pode aparecer em dois perfis. Sem o unique, o banco aceitaria 1:N.
*/
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('author_profiles', function (Blueprint $table) {
            $table->id();

            // FK no padrão Laravel: <model no singular>_id  ->  author_id
            // constrained() descobre sozinho a tabela "authors" pelo nome.
            // cascadeOnDelete(): apagou o autor, o perfil vai junto.
            $table->foreignId('author_id')
                  ->unique()
                  ->constrained()
                  ->cascadeOnDelete();

            $table->text('bio');
            $table->date('birth_date');
            $table->string('birth_city', 80);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('author_profiles');
    }
};
