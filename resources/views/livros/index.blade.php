@extends('layout')
@section('titulo', 'Livros')

@section('conteudo')
<h1>Livros</h1>
<p class="sub">Acervo da biblioteca</p>

<section class="card">
    <div class="barra">
        <span class="contagem">{{ $books->count() }} {{ $books->count() === 1 ? 'livro' : 'livros' }}</span>
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
</section>
@endsection
