<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Tabela "categories" (categorias de livros)
|--------------------------------------------------------------------------
| Lado "1" da relação 1:N com books:
|   uma categoria TEM MUITOS livros  -> Category::hasMany(Book::class)
|   um livro PERTENCE A uma categoria -> Book::belongsTo(Category::class)
|
| Padrão Laravel: nome da tabela no plural e em inglês, PK chamada "id".
*/
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();                       // PK: BIGINT UNSIGNED AUTO_INCREMENT "id"
            $table->string('name')->unique();   // nome da categoria (não repete)
            $table->timestamps();               // created_at e updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
