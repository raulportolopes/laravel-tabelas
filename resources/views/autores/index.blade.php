@extends('layout')
@section('titulo', 'Autores')

@section('conteudo')
<h1>Autores</h1>
<p class="sub">Autores cadastrados</p>

<section class="card">
    <div class="barra">
        <span class="contagem">{{ $authors->count() }} {{ $authors->count() === 1 ? 'autor' : 'autores' }}</span>
        <a href="{{ route('autores.create') }}" class="botao primario">+ Novo autor</a>
    </div>

    <div class="tabela">
        <table>
            <thead>
                <tr>
                    <th scope="col" class="num">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">País</th>
                    <th scope="col" class="esconde-celular">Cadastro</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($authors as $author)
                <tr>
                    <td class="num">{{ $author->id }}</td>
                    <td class="titulo">{{ $author->name }}</td>
                    <td>{{ $author->country }}</td>
                    <td class="esconde-celular">{{ $author->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="vazio">Nenhum autor cadastrado.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
