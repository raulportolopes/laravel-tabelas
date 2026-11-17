@extends('layout')
@section('titulo', 'Livros')

@section('conteudo')
<h1>Livros</h1>
<p class="sub">Acervo da biblioteca</p>

<section class="card">
    <div class="barra">
        <form method="get" action="{{ route('livros.index') }}">
            <label>Ordenar por
                <select name="ordem">
                    <option value="title" @selected(request('ordem') === 'title')>Título</option>
                    <option value="published_at" @selected(request('ordem') === 'published_at')>Data de publicação</option>
                    <option value="pages" @selected(request('ordem') === 'pages')>Páginas</option>
                    <option value="created_at" @selected(request('ordem') === 'created_at')>Data de cadastro</option>
                </select>
            </label>
            <label>Direção
                <select name="direcao">
                    <option value="asc" @selected(request('direcao') === 'asc')>Crescente</option>
                    <option value="desc" @selected(request('direcao') === 'desc')>Decrescente</option>
                </select>
            </label>
            <button type="submit" class="botao secundario">Aplicar</button>
        </form>

        <a href="{{ route('livros.create') }}" class="botao primario">+ Novo livro</a>
    </div>

    <div class="tabela">
        <table>
            <thead>
                <tr>
                    <th scope="col">Título</th>
                    <th scope="col">Autor</th>
                    <th scope="col" class="esconde-celular">Categoria</th>
                    <th scope="col" class="num esconde-celular">Páginas</th>
                    <th scope="col" class="esconde-celular">Publicação</th>
                    <th scope="col" class="esconde-celular">Cadastro</th>
                    <th scope="col"><span class="esconde-celular">Ações</span></th>
                </tr>
            </thead>
            <tbody>
            @forelse ($books as $book)
                <tr>
                    <td class="titulo">{{ $book->title }}</td>
                    <td>{{ $book->author_id }}</td>
                    <td class="esconde-celular"><span class="selo">{{ $book->category_id }}</span></td>
                    <td class="num esconde-celular">{{ $book->pages }}</td>
                    <td class="esconde-celular">{{ $book->published_at->format('d/m/Y') }}</td>
                    <td class="esconde-celular">{{ $book->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <form method="post" action="{{ route('livros.destroy', $book) }}"
                              onsubmit="return confirm('Excluir o livro {{ addslashes($book->title) }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="botao perigo" aria-label="Excluir {{ $book->title }}">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="vazio">Nenhum livro cadastrado.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="rodape-tabela">{{ $books->count() }} {{ $books->count() === 1 ? 'livro' : 'livros' }}</div>
</section>
@endsection
