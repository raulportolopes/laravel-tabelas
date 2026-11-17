<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Support\ExemploConsulta;
use Illuminate\Http\Request;

/**
 * PARTE 1 DO QUADRO: ordenação
 *
 *   Model::oldest('coluna')   -> ORDER BY coluna ASC   (mais ANTIGO primeiro)
 *   Model::latest('coluna')   -> ORDER BY coluna DESC  (mais RECENTE primeiro)
 *   Model::orderBy('coluna')  -> ORDER BY coluna ASC   (ou 'desc' no 2º parâmetro)
 *
 * Sem coluna, oldest() e latest() usam created_at.
 * Todos devolvem um query builder: é preciso terminar com ->get(), ->first(),
 * ->paginate()... para a consulta ir de fato ao banco.
 */
class OrdenacaoController extends Controller
{
    public function index(Request $request)
    {
        $exemplos = [
            ExemploConsulta::rodar(
                titulo: 'orderBy(coluna): ordem alfabética',
                tag: 'orderBy',
                explicacao: 'Sem o segundo parâmetro, <code>orderBy</code> usa <b>ASC</b> (A→Z, menor→maior, mais antigo→mais novo).',
                consulta: fn () => Book::orderBy('title')->get(),
                linha: fn (Book $livro) => ['Título' => $livro->title, 'Páginas' => $livro->pages],
            ),
            ExemploConsulta::rodar(
                titulo: "orderBy(coluna, 'desc'): do maior para o menor",
                tag: 'orderBy',
                explicacao: "O segundo parâmetro aceita <code>'asc'</code> ou <code>'desc'</code>. Atalho equivalente: <code>orderByDesc('pages')</code>.",
                consulta: fn () => Book::orderBy('pages', 'desc')->get(),
                linha: fn (Book $livro) => ['Título' => $livro->title, 'Páginas' => $livro->pages],
            ),
            ExemploConsulta::rodar(
                titulo: 'oldest(coluna): o mais antigo primeiro',
                tag: 'oldest',
                explicacao: '<code>oldest(\'published_at\')</code> é só um atalho para <code>orderBy(\'published_at\', \'asc\')</code>. Confira no SQL gerado.',
                consulta: fn () => Book::oldest('published_at')->get(),
                linha: fn (Book $livro) => ['Título' => $livro->title, 'Publicado em' => $livro->published_at->format('d/m/Y')],
            ),
            ExemploConsulta::rodar(
                titulo: 'latest(coluna): o mais recente primeiro',
                tag: 'latest',
                explicacao: '<code>latest(\'published_at\')</code> = <code>orderBy(\'published_at\', \'desc\')</code>. É o que se usa em "últimas notícias", "pedidos mais recentes" etc.',
                consulta: fn () => Book::latest('published_at')->get(),
                linha: fn (Book $livro) => ['Título' => $livro->title, 'Publicado em' => $livro->published_at->format('d/m/Y')],
            ),
            ExemploConsulta::rodar(
                titulo: 'latest() SEM coluna: usa created_at',
                tag: 'latest',
                explicacao: 'Pegadinha de prova: sem coluna, a ordenação é pela data de <b>cadastro no sistema</b> (<code>created_at</code>), não pela publicação. Compare com o card anterior: a ordem é outra.',
                consulta: fn () => Book::latest()->get(),
                linha: fn (Book $livro) => ['Título' => $livro->title, 'Cadastrado em' => $livro->created_at->format('d/m/Y H:i'), 'Publicado em' => $livro->published_at->format('d/m/Y')],
            ),
            ExemploConsulta::rodar(
                titulo: 'Os 3 mais recentes: latest(coluna) + take(3)',
                tag: 'latest',
                explicacao: '<code>take(3)</code> vira <code>LIMIT 3</code>. Combinação muito comum: "mostre os 3 últimos...".',
                consulta: fn () => Book::latest('published_at')->take(3)->get(),
                linha: fn (Book $livro) => ['Título' => $livro->title, 'Publicado em' => $livro->published_at->format('d/m/Y')],
            ),
            ExemploConsulta::rodar(
                titulo: 'Ordenar por duas colunas (desempate)',
                tag: 'orderBy',
                explicacao: 'Pode encadear: primeiro agrupa por categoria, e dentro de cada categoria ordena pelo título. A ordem dos <code>orderBy</code> é a ordem de prioridade.',
                consulta: fn () => Book::orderBy('category_id')->orderBy('title')->get(),
                linha: fn (Book $livro) => ['Categoria (id)' => $livro->category_id, 'Título' => $livro->title],
            ),
            ExemploConsulta::rodar(
                titulo: 'first(): só o primeiro da ordenação',
                tag: 'oldest',
                explicacao: '<code>first()</code> vira <code>LIMIT 1</code> e devolve <b>um</b> model (ou <code>null</code>), não uma lista. Aqui: o livro mais antigo.',
                consulta: fn () => Book::oldest('published_at')->first(),
                linha: fn (Book $livro) => ['Título' => $livro->title, 'Publicado em' => $livro->published_at->format('d/m/Y')],
            ),
        ];

        return view('ordenacao', [
            'exemplos'     => $exemplos,
            'experimente'  => $this->experimente($request),
        ]);
    }

    /**
     * "Experimente": o usuário escolhe coluna e método no formulário.
     *
     * SEGURANÇA: nunca passe o texto vindo do usuário direto para orderBy().
     * Sempre confira contra uma LISTA BRANCA de colunas permitidas.
     */
    private function experimente(Request $request): array
    {
        $colunas = [
            'title'        => 'title (título)',
            'pages'        => 'pages (páginas)',
            'published_at' => 'published_at (publicação)',
            'created_at'   => 'created_at (cadastro)',
        ];
        $metodos = [
            'oldest'       => 'oldest(coluna)',
            'latest'       => 'latest(coluna)',
            'orderBy-asc'  => 'orderBy(coluna)',
            'orderBy-desc' => "orderBy(coluna, 'desc')",
        ];

        // Valor inválido? Volta para o padrão em vez de quebrar a página.
        $coluna = $request->query('coluna');
        $metodo = $request->query('metodo');
        $coluna = is_string($coluna) && array_key_exists($coluna, $colunas) ? $coluna : 'published_at';
        $metodo = is_string($metodo) && array_key_exists($metodo, $metodos) ? $metodo : 'latest';

        $query = match ($metodo) {
            'oldest'       => Book::oldest($coluna),
            'latest'       => Book::latest($coluna),
            'orderBy-asc'  => Book::orderBy($coluna),
            'orderBy-desc' => Book::orderBy($coluna, 'desc'),
        };

        $codigo = match ($metodo) {
            'oldest'       => "Book::oldest('$coluna')->get()",
            'latest'       => "Book::latest('$coluna')->get()",
            'orderBy-asc'  => "Book::orderBy('$coluna')->get()",
            'orderBy-desc' => "Book::orderBy('$coluna', 'desc')->get()",
        };

        return [
            'colunas' => $colunas,
            'metodos' => $metodos,
            'coluna'  => $coluna,
            'metodo'  => $metodo,
            'codigo'  => $codigo,
            'sql'     => $query->toSql(),   // toSql() mostra o SQL sem executar
            'livros'  => $query->get(),
        ];
    }
}
