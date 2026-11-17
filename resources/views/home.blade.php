@extends('layout')
@section('titulo', 'Início')

@section('conteudo')
<h1>Ordenação e relações de tabelas no Laravel</h1>
<p>Sistema de estudo com o tema <b>Biblioteca</b>. Cada página mostra a consulta Eloquent, o SQL que o Laravel gerou,
   quantas consultas foram ao banco e o resultado.</p>

<div class="grade">
    <section class="card">
        <h2>1. Ordenação</h2>
        <p><code>::oldest(coluna)</code>, <code>::latest(coluna)</code> e <code>::orderBy(coluna)</code>, com um formulário para experimentar.</p>
        <p><a href="{{ route('ordenacao') }}">Abrir ordenação →</a></p>
    </section>
    <section class="card">
        <h2>2. Relações</h2>
        <p><code>belongsTo</code> (N:1), <code>hasMany</code> (1:N), <code>hasOne</code> (1:1) e eager loading com <code>::with('relacionamento')</code>.</p>
        <p><a href="{{ route('relacoes') }}">Abrir relações →</a></p>
    </section>
</div>

<h2>O banco de dados</h2>
<p>Tabelas em inglês, no plural, PK <code>id</code> e FK no formato <code>&lt;singular&gt;_id</code>: é o padrão que faz o Laravel
   descobrir as relações sozinho. <span class="pk">PK</span> = chave primária, <span class="fk">FK</span> = chave estrangeira.</p>
<div class="grade">
    <div class="card tabela-bd"><h3>categories ({{ $totais['categories'] }})</h3>
        <ul><li><span class="pk">id</span> PK</li><li>name (único)</li><li>created_at, updated_at</li></ul></div>
    <div class="card tabela-bd"><h3>authors ({{ $totais['authors'] }})</h3>
        <ul><li><span class="pk">id</span> PK</li><li>name</li><li>country</li><li>created_at, updated_at</li></ul></div>
    <div class="card tabela-bd"><h3>author_profiles ({{ $totais['author_profiles'] }})</h3>
        <ul><li><span class="pk">id</span> PK</li><li><span class="fk">author_id</span> FK → authors.id <b>UNIQUE</b></li><li>bio, birth_date, birth_city</li><li>created_at, updated_at</li></ul></div>
    <div class="card tabela-bd"><h3>books ({{ $totais['books'] }})</h3>
        <ul><li><span class="pk">id</span> PK</li><li><span class="fk">author_id</span> FK → authors.id</li><li><span class="fk">category_id</span> FK → categories.id</li><li>title, pages, published_at</li><li>created_at, updated_at</li></ul></div>
</div>

<div class="card">
    <h2>Regra de bolso</h2>
    <p><b>Quem tem a coluna <code>_id</code> usa <code>belongsTo</code>.</b> O outro lado usa <code>hasMany</code> (se pode ter vários)
       ou <code>hasOne</code> (se só pode ter um; no banco, a FK é <code>UNIQUE</code>).</p>
    <div class="tabela"><table>
        <thead><tr><th>Cardinalidade</th><th>Método</th><th>Model</th><th>Relação</th><th>Leitura</th></tr></thead>
        <tbody>
        @foreach($relacoes as [$card, $metodo, $model, $rel, $texto])
            <tr><td>{{ $card }}</td><td><code>{{ $metodo }}</code></td><td>{{ $model }}</td><td><code>${{ lcfirst($model) }}->{{ $rel }}</code></td><td>{{ $texto }}</td></tr>
        @endforeach
        </tbody>
    </table></div>
</div>

<h2>O código das relações (lido dos models)</h2>
@foreach($relacoes as [$card, $metodo, $model, $rel])
    <div class="card">
        <span class="tag">{{ $card }} {{ $metodo }}</span>
        <h2>app/Models/{{ $model }}.php → {{ $rel }}()</h2>
        <pre><code>{{ $fonte($model, $rel) }}</code></pre>
    </div>
@endforeach
@endsection
