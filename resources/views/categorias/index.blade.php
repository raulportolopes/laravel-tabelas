@extends('layout')
@section('titulo', 'Categorias')

@section('conteudo')
<h1>Categorias</h1>
<p class="sub">Categorias do acervo</p>

<section class="card">
    <div class="barra">
        <span class="contagem">{{ $categories->count() }} {{ $categories->count() === 1 ? 'categoria' : 'categorias' }}</span>
        <a href="{{ route('categorias.create') }}" class="botao primario">+ Nova categoria</a>
    </div>

    <div class="tabela">
        <table>
            <thead>
                <tr>
                    <th scope="col" class="num">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col" class="esconde-celular">Cadastro</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td class="num">{{ $category->id }}</td>
                    <td class="titulo"><span class="selo">{{ $category->name }}</span></td>
                    <td class="esconde-celular">{{ $category->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="vazio">Nenhuma categoria cadastrada.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
