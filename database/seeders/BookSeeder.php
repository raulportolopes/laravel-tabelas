<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $autor = Author::pluck('id', 'name');
        $categoria = Category::pluck('id', 'name');

        $livros = [
            ['Memórias Póstumas de Brás Cubas', 'Machado de Assis', 'Romance', 368, '1881-03-15', '2026-06-03 10:00:00'],
            ['Dom Casmurro', 'Machado de Assis', 'Romance', 256, '1899-12-01', '2026-06-01 09:00:00'],
            ['Quincas Borba', 'Machado de Assis', 'Romance', 304, '1891-06-10', '2026-07-12 15:30:00'],
            ['Papéis Avulsos', 'Machado de Assis', 'Conto', 240, '1882-10-20', '2026-08-08 08:45:00'],
            ['Perto do Coração Selvagem', 'Clarice Lispector', 'Romance', 224, '1943-12-01', '2026-06-20 13:10:00'],
            ['A Hora da Estrela', 'Clarice Lispector', 'Romance', 88, '1977-10-26', '2026-06-02 11:20:00'],
            ['Laços de Família', 'Clarice Lispector', 'Conto', 160, '1960-07-01', '2026-09-30 17:00:00'],
            ['Alguma Poesia', 'Carlos Drummond de Andrade', 'Poesia', 120, '1930-04-15', '2026-07-01 10:40:00'],
            ['A Rosa do Povo', 'Carlos Drummond de Andrade', 'Poesia', 208, '1945-11-05', '2026-06-15 16:00:00'],
            ['Fala, Amendoeira', 'Carlos Drummond de Andrade', 'Crônica', 190, '1957-05-20', '2026-10-05 09:30:00'],
            ['Capitães da Areia', 'Jorge Amado', 'Romance', 280, '1937-09-01', '2026-06-25 14:00:00'],
            ['Gabriela, Cravo e Canela', 'Jorge Amado', 'Romance', 424, '1958-08-10', '2026-08-19 12:00:00'],
            ['Dona Flor e Seus Dois Maridos', 'Jorge Amado', 'Romance', 448, '1966-06-01', '2026-07-22 18:15:00'],
            ['Romanceiro da Inconfidência', 'Cecília Meireles', 'Poesia', 296, '1953-04-21', '2026-09-02 07:50:00'],
            ['Ou Isto ou Aquilo', 'Cecília Meireles', 'Poesia', 64, '1964-03-01', '2026-06-10 10:10:00'],
        ];

        foreach ($livros as [$titulo, $nomeAutor, $nomeCategoria, $paginas, $publicacao, $cadastro]) {
            $livro = new Book([
                'title'        => $titulo,
                'author_id'    => $autor[$nomeAutor],
                'category_id'  => $categoria[$nomeCategoria],
                'pages'        => $paginas,
                'published_at' => $publicacao,
            ]);
            $livro->created_at = $cadastro;
            $livro->updated_at = $cadastro;
            $livro->save();
        }
    }
}
