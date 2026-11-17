@extends('layout')
@section('titulo', 'Ordenação')

@section('conteudo')
<h1>Ordenação: oldest, latest e orderBy</h1>
<div class="card">
    <div class="tabela"><table>
        <thead><tr><th>Você escreve</th><th>O Laravel gera</th><th>Quando usar</th></tr></thead>
        <tbody>
            <tr><td><code>Book::orderBy('title')</code></td><td><code>ORDER BY title ASC</code></td><td>Ordem crescente de qualquer coluna</td></tr>
            <tr><td><code>Book::orderBy('pages', 'desc')</code></td><td><code>ORDER BY pages DESC</code></td><td>Ordem decrescente</td></tr>
            <tr><td><code>Book::oldest('published_at')</code></td><td><code>ORDER BY published_at ASC</code></td><td>Mais antigo primeiro</td></tr>
            <tr><td><code>Book::latest('published_at')</code></td><td><code>ORDER BY published_at DESC</code></td><td>Mais recente primeiro</td></tr>
            <tr><td><code>Book::latest()</code> / <code>oldest()</code></td><td><code>ORDER BY created_at ...</code></td><td>Sem coluna = data de cadastro</td></tr>
        </tbody>
    </table></div>
    <p>Lembre: isso monta a consulta. Ela só vai ao banco no <code>->get()</code>, <code>->first()</code>, <code>->paginate()</code>...</p>
</div>

{{-- Formulário GET: os parâmetros vão na URL (?coluna=...&metodo=...) --}}
<section class="card" id="experimente">
    <span class="tag">experimente</span>
    <h2>Escolha a coluna e o método</h2>
    <form class="experimente" method="get" action="{{ route('ordenacao') }}#experimente">
        <label>Método
            <select name="metodo">
                @foreach($experimente['metodos'] as $valor => $texto)
                    <option value="{{ $valor }}" @selected($valor === $experimente['metodo'])>{{ $texto }}</option>
                @endforeach
            </select>
        </label>
        <label>Coluna
            <select name="coluna">
                @foreach($experimente['colunas'] as $valor => $texto)
                    <option value="{{ $valor }}" @selected($valor === $experimente['coluna'])>{{ $texto }}</option>
                @endforeach
            </select>
        </label>
        <button type="submit">Ordenar</button>
    </form>
    <div class="rotulo">Código</div>
    <pre><code>{{ $experimente['codigo'] }}</code></pre>
    <div class="rotulo sql">SQL (toSql)</div>
    <div class="sql"><pre><code>{{ $experimente['sql'] }}</code></pre></div>
    <div class="tabela"><table>
        <thead><tr><th>#</th><th>title</th><th>pages</th><th>published_at</th><th>created_at</th></tr></thead>
        <tbody>
        @foreach($experimente['livros'] as $livro)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $livro->title }}</td>
                <td>{{ $livro->pages }}</td>
                <td>{{ $livro->published_at->format('d/m/Y') }}</td>
                <td>{{ $livro->created_at->format('d/m/Y H:i') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table></div>
</section>

@foreach($exemplos as $e)
    @include('partials.exemplo', ['e' => $e, 'n' => $loop->iteration])
@endforeach
@endsection
