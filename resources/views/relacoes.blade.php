@extends('layout')
@section('titulo', 'Relações')

@section('conteudo')
<h1>Relações de tabelas e eager loading</h1>
<div class="card">
    <div class="tabela"><table>
        <thead><tr><th>Quadro</th><th>Método no model</th><th>Exemplo aqui</th><th>O que devolve</th></tr></thead>
        <tbody>
            <tr><td>N:1</td><td><code>belongsTo(Model::class)</code></td><td><code>$livro->author</code></td><td>Um model</td></tr>
            <tr><td>1:N</td><td><code>hasMany(Model::class)</code></td><td><code>$autor->books</code></td><td>Collection (pode ser vazia)</td></tr>
            <tr><td>1:1</td><td><code>hasOne(Model::class)</code></td><td><code>$autor->profile</code></td><td>Um model ou <code>null</code></td></tr>
            <tr><td>E + R</td><td><code>Model::with('relacao')</code></td><td><code>Book::with('author')</code></td><td>Carrega a relação antes (evita N+1)</td></tr>
        </tbody>
    </table></div>
    <p>Fique de olho no contador de SQL de cada card: <span class="contador ok">verde</span> = poucas consultas,
       <span class="contador alerta">vermelho</span> = N+1.</p>
</div>

@foreach($exemplos as $e)
    @include('partials.exemplo', ['e' => $e, 'n' => $loop->iteration])
@endforeach
@endsection
